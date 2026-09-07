<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    /**
     * Show the image fetcher dashboard.
     */
    public function index()
    {
        $stats       = $this->getStats();
        $progress    = $this->loadProgress();
        $companies   = $this->getCompaniesNeedingImages();
        $recentSaved = array_slice(array_reverse($progress['saved'] ?? []), 0, 20);
        $recentFailed = array_slice(array_reverse($progress['failed'] ?? []), 0, 20);

        return view('admin.products.image_fetcher', compact(
            'stats', 'progress', 'companies', 'recentSaved', 'recentFailed'
        ));
    }

    /**
     * Trigger image fetching via Artisan command.
     */
    public function fetchImages(Request $request)
    {
        $request->validate([
            'limit'   => 'nullable|integer|min:1|max:500',
            'company' => 'nullable|string|max:100',
            'delay'   => 'nullable|integer|min:500|max:10000',
        ]);

        $limit   = $request->input('limit', 30);
        $company = $request->input('company', '');
        $delay   = $request->input('delay', 1500);

        $args = [
            '--limit' => $limit,
            '--delay' => $delay,
        ];
        if ($company) {
            $args['--company'] = $company;
        }

        $exitCode = Artisan::call('products:fetch-images', $args);
        $output   = Artisan::output();

        return redirect()->route('admin.product-images.index')
            ->with('fetch_result', [
                'exit_code' => $exitCode,
                'output'    => $output,
            ]);
    }

    /**
     * Reset / clear the progress log.
     */
    public function resetProgress()
    {
        $progressFile = storage_path('app/image_fetch_progress.json');
        if (file_exists($progressFile)) {
            unlink($progressFile);
        }
        return redirect()->route('admin.product-images.index')
            ->with('success', 'Progress log cleared.');
    }

    /**
     * Get summary stats.
     */
    private function getStats(): array
    {
        $total    = Product::count();
        $withImg  = Product::whereNotNull('image')->where('image', '!=', '')->count();
        $missing  = $total - $withImg;

        return [
            'total'    => $total,
            'with_img' => $withImg,
            'missing'  => $missing,
            'pct'      => $total > 0 ? round(($withImg / $total) * 100, 1) : 0,
        ];
    }

    /**
     * Get companies sorted by missing image count.
     */
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

    /**
     * Load progress JSON.
     */
    private function loadProgress(): array
    {
        $file = storage_path('app/image_fetch_progress.json');
        if (file_exists($file)) {
            return json_decode(file_get_contents($file), true) ?? [];
        }
        return ['saved' => [], 'failed' => [], 'total_saved' => 0, 'total_failed' => 0];
    }
}
