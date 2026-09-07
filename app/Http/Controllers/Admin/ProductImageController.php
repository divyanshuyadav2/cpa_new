<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    private string $progressFile;
    private string $lockFile;

    public function __construct()
    {
        $this->progressFile = storage_path('app/image_fetch_progress.json');
        $this->lockFile     = storage_path('app/image_fetch.lock');
    }

    /**
     * Show the image fetcher dashboard.
     */
    public function index()
    {
        $stats        = $this->getStats();
        $progress     = $this->loadProgress();
        $companies    = $this->getCompaniesNeedingImages();
        $recentSaved  = array_slice(array_reverse($progress['saved']  ?? []), 0, 20);
        $recentFailed = array_slice(array_reverse($progress['failed'] ?? []), 0, 20);
        $isRunning    = $this->isRunning();

        return view('admin.products.image_fetcher', compact(
            'stats', 'progress', 'companies', 'recentSaved', 'recentFailed', 'isRunning'
        ));
    }

    /**
     * Trigger image fetching as a BACKGROUND process (non-blocking).
     * Returns JSON immediately so the UI can start polling.
     */
    public function fetchImages(Request $request)
    {
        $request->validate([
            'limit'   => 'nullable|integer|min:1|max:500',
            'company' => 'nullable|string|max:100',
            'delay'   => 'nullable|integer|min:500|max:10000',
            'force'   => 'nullable|boolean',
        ]);

        if ($this->isRunning()) {
            return response()->json([
                'status'  => 'already_running',
                'message' => 'A fetch job is already running. Please wait for it to finish.',
            ], 409);
        }

        $limit   = (int) $request->input('limit', 30);
        $company = (string) $request->input('company', '');
        $delay   = (int) $request->input('delay', 1500);
        $force   = $request->boolean('force');

        $phpBin   = \PHP_BINARY;                           // e.g. C:\php\php.exe
        $artisan  = base_path('artisan');                  // e.g. C:\...\artisan
        $logFile  = storage_path('app/image_fetch_output.log');

        // Write lock file so UI knows it's running
        \file_put_contents($this->lockFile, \json_encode([
            'started_at' => now()->toDateTimeString(),
            'limit'      => $limit,
            'company'    => $company,
        ]));

        // ── Launch background process ─────────────────────────────────
        if (\PHP_OS_FAMILY === 'Windows') {
            // Write a temp .bat file — handles Windows path quoting reliably
            $batFile = storage_path('app/fetch_run_' . \time() . '.bat');

            $args  = "--limit={$limit} --delay={$delay}";
            if ($company) {
                $args .= ' --company="' . \str_replace('"', '\"', $company) . '"';
            }
            if ($force) {
                $args .= ' --force';
            }

            $bat  = "@echo off\r\n";
            $bat .= "\"{$phpBin}\" \"{$artisan}\" products:fetch-images {$args} > \"{$logFile}\" 2>&1\r\n";
            $bat .= "del \"{$batFile}\"\r\n";   // self-clean

            \file_put_contents($batFile, $bat);

            // start "" /B  —  run without a visible window, detached
            \pclose(\popen('start "" /B cmd /C "' . $batFile . '"', 'r'));

        } else {
            // Unix / Linux
            $args = "--limit={$limit} --delay={$delay}";
            if ($company) $args .= ' --company=' . \escapeshellarg($company);
            if ($force)   $args .= ' --force';

            $cmd = \escapeshellarg($phpBin) . ' '
                 . \escapeshellarg($artisan)
                 . " products:fetch-images {$args}"
                 . ' > ' . \escapeshellarg($logFile) . ' 2>&1 &';

            \exec($cmd);
        }

        return response()->json([
            'status'  => 'started',
            'message' => "Background fetch started: {$limit} products, {$delay}ms delay.",
        ]);
    }

    /**
     * AJAX endpoint — returns live stats + running status + per-run data.
     * The UI polls this every 3 seconds.
     */
    public function pollStatus()
    {
        $stats     = $this->getStats();
        $progress  = $this->loadProgress();
        $isRunning = $this->isRunning();

        // Auto-remove stale lock files (process finished but lock wasn't cleaned)
        if ($isRunning && $this->isLockStale()) {
            @unlink($this->lockFile);
            $isRunning = false;
        }

        return response()->json([
            'is_running'    => $isRunning,
            'stats'         => $stats,
            'total_saved'   => $progress['total_saved']  ?? 0,
            'total_failed'  => $progress['total_failed'] ?? 0,
            'last_run'      => $progress['last_run']     ?? null,
            'current_run'   => $progress['current_run']  ?? null,   // live per-product data
            'run_history'   => $progress['run_history']  ?? [],      // past runs
            'recent_saved'  => array_slice(array_reverse($progress['saved']  ?? []), 0, 5),
            'recent_failed' => array_slice(array_reverse($progress['failed'] ?? []), 0, 5),
        ]);
    }

    /**
     * Stop a running fetch job.
     */
    public function stopFetch()
    {
        if (\file_exists($this->lockFile)) {
            @\unlink($this->lockFile);
        }
        return response()->json(['status' => 'stopped']);
    }

    /**
     * Reset / clear the progress log.
     */
    public function resetProgress()
    {
        if (\file_exists($this->progressFile)) {
            \unlink($this->progressFile);
        }
        if (\file_exists($this->lockFile)) {
            \unlink($this->lockFile);
        }
        return response()->json(['status' => 'reset', 'message' => 'Progress log cleared.']);
    }

    /**
     * Get tail of the output log for live display.
     */
    public function getLog()
    {
        $logFile = storage_path('app/image_fetch_output.log');
        if (!\file_exists($logFile)) {
            return response()->json(['lines' => []]);
        }

        // Read last 30 lines
        $lines = \file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $lines = \array_slice($lines, -30);

        // Strip ANSI escape codes
        $lines = \array_map(fn($l) => \preg_replace('/\x1b\[[0-9;]*m/', '', $l), $lines);

        return response()->json(['lines' => \array_values($lines)]);
    }

    // ─── Private Helpers ─────────────────────────────────────────────────────

    private function isRunning(): bool
    {
        return \file_exists($this->lockFile);
    }

    /** Lock file older than 30 minutes is considered stale */
    private function isLockStale(): bool
    {
        if (!\file_exists($this->lockFile)) return false;
        return (\time() - \filemtime($this->lockFile)) > 1800;
    }

    private function getStats(): array
    {
        $total   = Product::count();
        $withImg = Product::whereNotNull('image')->where('image', '!=', '')->count();
        $missing = $total - $withImg;

        return [
            'total'    => $total,
            'with_img' => $withImg,
            'missing'  => $missing,
            'pct'      => $total > 0 ? round(($withImg / $total) * 100, 1) : 0,
        ];
    }

    private function getCompaniesNeedingImages(): \Illuminate\Database\Eloquent\Collection
    {
        return Company::withCount([
            'products as total_products',
            'products as missing_images' => fn($q) => $q->where(fn($q2) => $q2->whereNull('image')->orWhere('image', '')),
        ])
        ->having('missing_images', '>', 0)
        ->orderByDesc('missing_images')
        ->get();
    }

    private function loadProgress(): array
    {
        if (\file_exists($this->progressFile)) {
            return \json_decode(\file_get_contents($this->progressFile), true) ?? [];
        }
        return ['saved' => [], 'failed' => [], 'total_saved' => 0, 'total_failed' => 0];
    }
}
