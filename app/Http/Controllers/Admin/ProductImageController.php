<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
            // Write a temp .cmd runner file — avoids quote escaping issues and enables true detached execution
            $cmdFile = storage_path('app/run_fetch_' . \time() . '.cmd');

            $args = "--limit={$limit} --delay={$delay}";
            if ($company) {
                $args .= ' --company=' . \escapeshellarg($company);
            }
            if ($force) {
                $args .= ' --force';
            }

            $cmdContent  = "@echo off\r\n";
            $cmdContent .= "\"{$phpBin}\" \"{$artisan}\" products:fetch-images {$args} > \"{$logFile}\" 2>&1\r\n";
            $cmdContent .= "del \"{$cmdFile}\"\r\n";

            \file_put_contents($cmdFile, $cmdContent);

            // PowerShell Start-Process launches an OS-level detached process unaffected by web request termination
            $psCmd = 'powershell -NoProfile -ExecutionPolicy Bypass -Command "Start-Process \'' . $cmdFile . '\' -WindowStyle Hidden"';
            \pclose(\popen($psCmd, 'r'));

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

    private function saveProgress(array $progress): void
    {
        \file_put_contents($this->progressFile, \json_encode($progress, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    /**
     * Web-safe direct chunk fetch endpoint.
     * Processes $chunkSize products synchronously and updates progress live.
     */
    public function fetchChunk(Request $request)
    {
        $chunkSize = (int) $request->input('chunk_size', 3);
        $chunkSize = max(1, min(10, $chunkSize));
        $company   = (string) $request->input('company', '');
        $force     = $request->boolean('force');

        $query = Product::with('company');
        if (!$force) {
            $query->where(function ($q) {
                $q->whereNull('image')->orWhere('image', '');
            });
        }
        if ($company !== '') {
            $query->whereHas('company', fn($q) => $q->where('name', $company));
        }

        $products = $query->take($chunkSize)->get();

        if ($products->isEmpty()) {
            return response()->json([
                'status'       => 'complete',
                'processed'    => 0,
                'saved_count'  => 0,
                'failed_count' => 0,
                'remaining'    => 0,
                'is_complete'  => true,
            ]);
        }

        $progress = $this->loadProgress();

        if (!isset($progress['current_run']) || $progress['current_run'] === null) {
            $runId = now()->format('Y-m-d H:i:s');
            $progress['current_run'] = [
                'run_id'       => $runId,
                'started_at'   => $runId,
                'limit'        => $chunkSize,
                'company'      => $company,
                'saved'        => [],
                'failed'       => [],
                'saved_count'  => 0,
                'failed_count' => 0,
            ];
        }

        $savedChunk  = [];
        $failedChunk = [];

        foreach ($products as $product) {
            $productName = trim($product->name);
            $companyName = $product->company ? trim($product->company->name) : 'unknown';
            $searchName  = $this->cleanProductName($productName);

            $imageUrl = $this->searchImage($searchName, $companyName);

            if (!$imageUrl) {
                $entry = [
                    'id'      => $product->id,
                    'name'    => $productName,
                    'company' => $companyName,
                    'at'      => now()->format('H:i:s'),
                ];
                $progress['failed'][] = $entry;
                $progress['current_run']['failed'][] = $entry;
                $progress['current_run']['failed_count'] = ($progress['current_run']['failed_count'] ?? 0) + 1;
                $progress['total_failed'] = ($progress['total_failed'] ?? 0) + 1;
                $failedChunk[] = $entry;
                continue;
            }

            $localPath = $this->downloadAndSave($imageUrl, $productName, $companyName);

            if ($localPath) {
                $product->image = $localPath;
                $product->save();

                $entry = [
                    'id'      => $product->id,
                    'name'    => $productName,
                    'company' => $companyName,
                    'path'    => $localPath,
                    'source'  => $imageUrl,
                    'at'      => now()->format('H:i:s'),
                ];
                $progress['saved'][] = $entry;
                $progress['current_run']['saved'][] = $entry;
                $progress['current_run']['saved_count'] = ($progress['current_run']['saved_count'] ?? 0) + 1;
                $progress['total_saved'] = ($progress['total_saved'] ?? 0) + 1;
                $savedChunk[] = $entry;
            } else {
                $entry = [
                    'id'      => $product->id,
                    'name'    => $productName,
                    'company' => $companyName,
                    'at'      => now()->format('H:i:s'),
                ];
                $progress['failed'][] = $entry;
                $progress['current_run']['failed'][] = $entry;
                $progress['current_run']['failed_count'] = ($progress['current_run']['failed_count'] ?? 0) + 1;
                $progress['total_failed'] = ($progress['total_failed'] ?? 0) + 1;
                $failedChunk[] = $entry;
            }
        }

        $progress['last_run'] = now()->format('Y-m-d H:i:s');
        $this->saveProgress($progress);

        $remaining = Product::where(fn($q) => $q->whereNull('image')->orWhere('image', ''))->count();

        return response()->json([
            'status'       => 'success',
            'processed'    => $products->count(),
            'saved_count'  => count($savedChunk),
            'failed_count' => count($failedChunk),
            'remaining'    => $remaining,
            'is_complete'  => $remaining === 0,
        ]);
    }

    private function cleanProductName(string $name): string
    {
        $clean = \ltrim($name, "* \t\n\r\0\x0B#/\\|@!~`");
        $clean = \preg_replace('/\s*[\(\[]\s*(TAB|TABLET|CAP|CAPSULE|SYP|SYRUP|INJ|INJECTION|CREAM|GEL|OINTMENT|OIN|SUSP|DROPS?|MG|ML|GM|PFS|AMP)\s*[\)\]]/i', '', $clean);
        $clean = \preg_replace('/\s+\b(TAB|TABLET|TABLETS|CAP|CAPSULE|CAPSULES|SYP|SYRUP|INJ|INJECTION|CREAM|GEL|SUSP|DROPS|SOLUTION|LOTION|KIT|TAN)\b$/i', '', $clean);
        $clean = \preg_replace('/\s+/', ' ', \trim($clean));
        return $clean ?: $name;
    }

    private function searchImage(string $productName, string $companyName): ?string
    {
        $cleanName = \preg_replace('/\s+/', ' ', $productName);
        $url = $this->search1mg($cleanName, $companyName);
        if ($url) return $url;
        $url = $this->searchNetmeds($cleanName);
        if ($url) return $url;
        $url = $this->searchPharmEasy($cleanName);
        if ($url) return $url;
        $url = $this->searchBingImages($cleanName . ' ' . $companyName . ' tablet medicine');
        if ($url) return $url;
        return null;
    }

    private function search1mg(string $name, string $company): ?string
    {
        try {
            $query  = \urlencode($name);
            $apiUrl = "https://www.1mg.com/pharmacy_api_gateway/v4/drug_skus/search?name={$query}&page=1&per_page=5";
            $resp   = $this->httpGet($apiUrl, ['Referer' => 'https://www.1mg.com/drugs-all-medicines', 'Accept' => 'application/json']);
            if ($resp) {
                $data = \json_decode($resp, true);
                $skus = $data['data']['sku_list'] ?? $data['data']['skus'] ?? [];
                foreach ($skus as $sku) {
                    $imgUrl = $sku['image'] ?? $sku['front_image'] ?? $sku['images'][0] ?? null;
                    if ($imgUrl && \filter_var($imgUrl, FILTER_VALIDATE_URL)) return $imgUrl;
                }
            }
            return $this->scrape1mgPage($name);
        } catch (\Throwable $e) { return null; }
    }

    private function scrape1mgPage(string $name): ?string
    {
        try {
            $query = \urlencode($name);
            $html  = $this->httpGet("https://www.1mg.com/search/all?name={$query}");
            if (!$html) return null;
            if (\preg_match('/"image"\s*:\s*"(https:\/\/onemg[^"]+)"/', $html, $m)) return $m[1];
            if (\preg_match('/content="(https:\/\/onemg\.gumlet\.io[^"]+)"/', $html, $m)) return $m[1];
            if (\preg_match('/https:\/\/onemg\.gumlet\.io\/[^"\'>\s]+\.(jpg|jpeg|png|webp)/i', $html, $m)) return $m[0];
        } catch (\Throwable $e) {}
        return null;
    }

    private function searchNetmeds(string $name): ?string
    {
        try {
            $query = \urlencode($name);
            $html  = $this->httpGet("https://www.netmeds.com/catalogsearch/result/?q={$query}", ['Referer' => 'https://www.netmeds.com/']);
            if ($html && \preg_match('/https:\/\/www\.netmeds\.com\/images\/product-v1\/full_image\/[^\'">\s]+\.(jpg|jpeg|png|webp)/i', $html, $m)) {
                return $m[0];
            }
        } catch (\Throwable $e) {}
        return null;
    }

    private function searchPharmEasy(string $name): ?string
    {
        try {
            $query = \urlencode($name);
            $html  = $this->httpGet("https://pharmeasy.in/search/all?name={$query}", ['Referer' => 'https://pharmeasy.in/']);
            if ($html && \preg_match('/https:\/\/assets\.pharmeasy\.in\/apothecary\/images\/[^\'">\s]+\.(jpg|jpeg|png|webp)/i', $html, $m)) {
                return $m[0];
            }
        } catch (\Throwable $e) {}
        return null;
    }

    private function searchBingImages(string $query): ?string
    {
        try {
            $q    = \urlencode($query . ' medicine');
            $html = $this->httpGet("https://www.bing.com/images/search?q={$q}&form=HDRSC2&first=1&tsc=ImageHoverTitle", ['Referer' => 'https://www.bing.com/']);
            if ($html && \preg_match('/murl&quot;:&quot;(https?:\/\/[^&]+\.(jpg|jpeg|png|webp))&quot;/i', $html, $m)) {
                $imgUrl = \html_entity_decode($m[1]);
                if (\filter_var($imgUrl, FILTER_VALIDATE_URL)) return $imgUrl;
            }
        } catch (\Throwable $e) {}
        return null;
    }

    private function downloadAndSave(string $imageUrl, string $productName, string $companyName): ?string
    {
        try {
            $imageData = $this->httpGet($imageUrl, [], true);
            if (!$imageData || \strlen($imageData) < 1000) return null;
            $ext = 'jpg';
            if (\preg_match('/\.(jpeg|jpg|png|webp|gif)(\?|$)/i', $imageUrl, $m)) {
                $ext = \strtolower($m[1]) === 'jpeg' ? 'jpg' : \strtolower($m[1]);
            }
            $companySafe = Str::slug($companyName, '_');
            $productSafe = Str::limit(Str::slug($productName, '_'), 60, '');
            $relativePath = "products/{$companySafe}/{$productSafe}.{$ext}";
            Storage::disk('public')->put($relativePath, $imageData);
            return 'storage/' . $relativePath;
        } catch (\Throwable $e) { return null; }
    }

    private function httpGet(string $url, array $extraHeaders = [], bool $binary = false): ?string
    {
        $ch = \curl_init();
        \curl_setopt_array($ch, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS      => 5,
            CURLOPT_TIMEOUT        => 15,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_USERAGENT      => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36',
            CURLOPT_HTTPHEADER     => \array_merge([
                'Accept-Language: en-US,en;q=0.9',
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            ], \array_map(fn($k, $v) => "{$k}: {$v}", \array_keys($extraHeaders), $extraHeaders)),
            CURLOPT_ENCODING       => '',
        ]);
        $result   = \curl_exec($ch);
        $httpCode = \curl_getinfo($ch, CURLINFO_HTTP_CODE);
        \curl_close($ch);
        if ($result === false || $httpCode < 200 || $httpCode >= 400) return null;
        return $result;
    }
}
