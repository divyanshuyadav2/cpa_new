<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\Company;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FetchProductImages extends Command
{
    protected $signature = 'products:fetch-images
                            {--limit=50 : Max products to process per run}
                            {--company= : Optionally filter by company name}
                            {--delay=1500 : Delay in ms between requests}
                            {--force : Re-fetch even for products that already have images}';

    protected $description = 'Scrape product images from 1mg, Netmeds, PharmEasy and save locally, organized by company.';

    // User-agent to avoid bot blocks
    private string $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36';

    // Progress file for tracking
    private string $progressFile;

    private string $lockFile;

    public function __construct()
    {
        parent::__construct();
        $this->progressFile = storage_path('app/image_fetch_progress.json');
        $this->lockFile     = storage_path('app/image_fetch.lock');
    }

    public function handle(): int
    {
        $limit   = (int) $this->option('limit');
        $delay   = (int) $this->option('delay');
        $force   = $this->option('force');
        $company = $this->option('company');

        $this->info("╔══════════════════════════════════════════════════╗");
        $this->info("║       Product Image Fetcher — CPA System         ║");
        $this->info("╚══════════════════════════════════════════════════╝");
        $this->newLine();

        // Load or init progress tracking
        $progress = $this->loadProgress();

        // Build query
        $query = Product::with('company')
            ->where(function ($q) use ($force) {
                if (!$force) {
                    $q->whereNull('image')->orWhere('image', '');
                }
            });

        if ($company) {
            $query->whereHas('company', fn($q) => $q->where('name', 'like', "%{$company}%"));
        }

        $total    = $query->count();
        $products = $query->take($limit)->get();

        $this->info("📦 Products without images: <fg=yellow>{$total}</>");
        $this->info("🔄 Processing up to: <fg=cyan>{$limit}</> this run");
        $this->newLine();

        $saved   = 0;
        $failed  = 0;
        $skipped = 0;

        // Initialise current_run block (polled live by the UI every 3s)
        $runId = now()->format('Y-m-d H:i:s');
        $progress['current_run'] = [
            'run_id'    => $runId,
            'started_at'=> $runId,
            'limit'     => $limit,
            'company'   => $company ?? '',
            'saved'     => [],
            'failed'    => [],
        ];
        $this->saveProgress($progress);

        $bar = $this->output->createProgressBar($products->count());
        $bar->setFormat(' %current%/%max% [%bar%] %percent:3s%% — %message%');
        $bar->start();

        foreach ($products as $product) {
            $productName = trim($product->name);
            $companyName = $product->company ? trim($product->company->name) : 'unknown';

            // Strip leading * and other noise before searching
            $searchName = $this->cleanProductName($productName);

            $bar->setMessage("Searching: {$searchName} (DB: {$productName})");
            $bar->advance();

            // Try to find image from multiple sources
            $imageUrl = $this->searchImage($searchName, $companyName);

            if (!$imageUrl) {
                $failed++;
                $progress['failed'][] = [
                    'id'      => $product->id,
                    'name'    => $productName,
                    'company' => $companyName,
                ];
                usleep($delay * 1000);
                continue;
            }

            // Download and save the image
            $localPath = $this->downloadAndSave($imageUrl, $productName, $companyName);

            if ($localPath) {
                $product->image = $localPath;
                $product->save();
                $saved++;

                $entry = [
                    'id'      => $product->id,
                    'name'    => $productName,
                    'company' => $companyName,
                    'path'    => $localPath,
                    'source'  => $imageUrl,
                    'at'      => now()->format('H:i:s'),
                ];
                $progress['saved'][]                    = $entry;
                $progress['current_run']['saved'][]     = $entry;
            } else {
                $failed++;

                $entry = [
                    'id'      => $product->id,
                    'name'    => $productName,
                    'company' => $companyName,
                    'source'  => $imageUrl,
                    'error'   => 'Download failed',
                    'at'      => now()->format('H:i:s'),
                ];
                $progress['failed'][]                   = $entry;
                $progress['current_run']['failed'][]    = $entry;
            }

            // Flush progress to disk after every product so UI sees live updates
            $progress['current_run']['saved_count']  = $saved;
            $progress['current_run']['failed_count'] = $failed;
            $this->saveProgress($progress);

            usleep($delay * 1000);
        }

        $bar->setMessage('Done!');
        $bar->finish();
        $this->newLine(2);

        // Update global counts
        $progress['total_saved']  = ($progress['total_saved']  ?? 0) + $saved;
        $progress['total_failed'] = ($progress['total_failed'] ?? 0) + $failed;
        $progress['last_run']     = now()->toDateTimeString();

        // Finalise current_run and push to history
        $progress['current_run']['finished_at']    = now()->format('Y-m-d H:i:s');
        $progress['current_run']['saved_count']    = $saved;
        $progress['current_run']['failed_count']   = $failed;
        $completedRun = $progress['current_run'];

        // Keep only last 10 runs in history
        $history = $progress['run_history'] ?? [];
        array_unshift($history, $completedRun);
        $progress['run_history'] = array_slice($history, 0, 10);

        // Clear live current_run (job done)
        $progress['current_run'] = null;

        $this->saveProgress($progress);

        // Final Report
        $remaining = Product::where(function ($q) {
            $q->whereNull('image')->orWhere('image', '');
        })->count();

        $totalProducts = Product::count();
        $totalWithImg  = Product::whereNotNull('image')->where('image', '!=', '')->count();

        $this->info("╔══════════════════════════════════════════════════╗");
        $this->info("║              ✅ RUN SUMMARY                      ║");
        $this->info("╚══════════════════════════════════════════════════╝");
        $this->table(
            ['Metric', 'Count'],
            [
                ['✅ Images saved this run',    $saved],
                ['❌ Failed this run',           $failed],
                ['⏩ Skipped this run',          $skipped],
                ['📦 Total products',            $totalProducts],
                ['🖼️  Total WITH image (DB)',     $totalWithImg],
                ['🔴 Still missing image',       $remaining],
                ['✅ All-time saved',            $progress['total_saved']],
                ['❌ All-time failed',           $progress['total_failed']],
            ]
        );

        $this->newLine();
        $this->info("Progress log: <fg=cyan>storage/app/image_fetch_progress.json</>");

        // Remove lock file so UI knows job finished
        if (file_exists($this->lockFile)) {
            @unlink($this->lockFile);
        }

        return Command::SUCCESS;
    }

    /**
     * Clean product name before using it in a web search.
     * Removes leading asterisks (*), hash (#), slashes, and other
     * noise characters that come from CSV imports.
     *
     * Examples:
     *   *BCCA PLUS       →  BCCA PLUS
     *   *CIRETA          →  CIRETA
     *   #DOTEX-80        →  DOTEX-80
     *   BCCA PLUS (TAB)  →  BCCA PLUS
     */
    private function cleanProductName(string $name): string
    {
        // Strip leading non-alphanumeric noise (*, #, -, /, spaces, etc.)
        $clean = ltrim($name, "* \t\n\r\0\x0B#/\\|@!~`");

        // Remove trailing dosage/form hints in brackets or standalone trailing words
        $clean = preg_replace('/\s*[\(\[]\s*(TAB|TABLET|CAP|CAPSULE|SYP|SYRUP|INJ|INJECTION|CREAM|GEL|OINTMENT|OIN|SUSP|DROPS?|MG|ML|GM|PFS|AMP)\s*[\)\]]/i', '', $clean);
        $clean = preg_replace('/\s+\b(TAB|TABLET|TABLETS|CAP|CAPSULE|CAPSULES|SYP|SYRUP|INJ|INJECTION|CREAM|GEL|SUSP|DROPS|SOLUTION|LOTION|KIT|TAN)\b$/i', '', $clean);

        // Collapse multiple spaces
        $clean = preg_replace('/\s+/', ' ', trim($clean));

        // If cleaning left us with nothing, fall back to the original
        return $clean ?: $name;
    }

    /**
     * Search for product image URL from multiple sources.
     */
    private function searchImage(string $productName, string $companyName): ?string
    {

        $cleanName = preg_replace('/\s+/', ' ', $productName);

        // Strategy 1: 1mg.com API-based search
        $url = $this->search1mg($cleanName, $companyName);
        if ($url) return $url;

        // Strategy 2: Netmeds search
        $url = $this->searchNetmeds($cleanName);
        if ($url) return $url;

        // Strategy 3: PharmEasy search
        $url = $this->searchPharmEasy($cleanName);
        if ($url) return $url;

        // Strategy 4: Google Images / Bing image fallback via scraping
        $url = $this->searchBingImages($cleanName . ' ' . $companyName . ' tablet medicine');
        if ($url) return $url;

        return null;
    }

    /**
     * Search 1mg.com for the product image.
     * Uses their public API endpoint.
     */
    private function search1mg(string $name, string $company): ?string
    {
        try {
            $query   = urlencode($name);
            $apiUrl  = "https://www.1mg.com/pharmacy_api_gateway/v4/drug_skus/search?name={$query}&page=1&per_page=5";

            $response = $this->httpGet($apiUrl, [
                'Referer'          => 'https://www.1mg.com/drugs-all-medicines',
                'X-Requested-With' => 'XMLHttpRequest',
                'Accept'           => 'application/json',
            ]);

            if (!$response) return null;

            $data = json_decode($response, true);

            // Dig into result
            $skus = $data['data']['sku_list'] ?? $data['data']['skus'] ?? [];

            foreach ($skus as $sku) {
                $imgUrl = $sku['image'] ?? $sku['front_image'] ?? $sku['images'][0] ?? null;
                if ($imgUrl && filter_var($imgUrl, FILTER_VALIDATE_URL)) {
                    return $imgUrl;
                }
            }

            // Fallback: scrape the search page HTML
            return $this->scrape1mgPage($name);
        } catch (\Throwable $e) {
            return null;
        }
    }

    /**
     * Scrape 1mg search page for first product image.
     */
    private function scrape1mgPage(string $name): ?string
    {
        try {
            $query   = urlencode($name);
            $url     = "https://www.1mg.com/search/all?name={$query}";
            $html    = $this->httpGet($url);
            if (!$html) return null;

            // Extract og:image or product image from JSON-LD / meta tags
            if (preg_match('/"image"\s*:\s*"(https:\/\/onemg[^"]+)"/', $html, $m)) {
                return $m[1];
            }
            if (preg_match('/content="(https:\/\/onemg\.gumlet\.io[^"]+)"/', $html, $m)) {
                return $m[1];
            }
            // Match any product image from 1mg CDN
            if (preg_match('/https:\/\/onemg\.gumlet\.io\/[^"\'>\s]+\.(jpg|jpeg|png|webp)/i', $html, $m)) {
                return $m[0];
            }
        } catch (\Throwable $e) {
            // ignore
        }
        return null;
    }

    /**
     * Search Netmeds for product image.
     */
    private function searchNetmeds(string $name): ?string
    {
        try {
            $query = urlencode($name);
            $url   = "https://www.netmeds.com/catalogsearch/result/?q={$query}";
            $html  = $this->httpGet($url, ['Referer' => 'https://www.netmeds.com/']);
            if (!$html) return null;

            // Netmeds uses specific img domains
            if (preg_match('/https:\/\/www\.netmeds\.com\/images\/product-v1\/full_image\/[^\'">\s]+\.(jpg|jpeg|png|webp)/i', $html, $m)) {
                return $m[0];
            }
        } catch (\Throwable $e) {
            // ignore
        }
        return null;
    }

    /**
     * Search PharmEasy for product image.
     */
    private function searchPharmEasy(string $name): ?string
    {
        try {
            $query = urlencode($name);
            $url   = "https://pharmeasy.in/search/all?name={$query}";
            $html  = $this->httpGet($url, ['Referer' => 'https://pharmeasy.in/']);
            if (!$html) return null;

            // PharmEasy CDN pattern
            if (preg_match('/https:\/\/assets\.pharmeasy\.in\/apothecary\/images\/[^\'">\s]+\.(jpg|jpeg|png|webp)/i', $html, $m)) {
                return $m[0];
            }
        } catch (\Throwable $e) {
            // ignore
        }
        return null;
    }

    /**
     * Search Bing Images for a pharma product image URL.
     */
    private function searchBingImages(string $query): ?string
    {
        try {
            $q    = urlencode($query . ' medicine');
            $url  = "https://www.bing.com/images/search?q={$q}&form=HDRSC2&first=1&tsc=ImageHoverTitle";
            $html = $this->httpGet($url, ['Referer' => 'https://www.bing.com/']);
            if (!$html) return null;

            // Bing embeds image URLs in murl attribute
            if (preg_match('/murl&quot;:&quot;(https?:\/\/[^&]+\.(jpg|jpeg|png|webp))&quot;/i', $html, $m)) {
                $imgUrl = html_entity_decode($m[1]);
                if (filter_var($imgUrl, FILTER_VALIDATE_URL)) {
                    return $imgUrl;
                }
            }
        } catch (\Throwable $e) {
            // ignore
        }
        return null;
    }

    /**
     * Download image from URL and save to storage/app/public/products/{company}/{slug}.{ext}
     * Returns the relative path saved in DB, or null on failure.
     */
    private function downloadAndSave(string $imageUrl, string $productName, string $companyName): ?string
    {
        try {
            $imageData = $this->httpGet($imageUrl, [], true);
            if (!$imageData || strlen($imageData) < 1000) {
                return null;
            }

            // Determine extension
            $ext = 'jpg';
            if (preg_match('/\.(jpeg|jpg|png|webp|gif)(\?|$)/i', $imageUrl, $m)) {
                $ext = strtolower($m[1]) === 'jpeg' ? 'jpg' : strtolower($m[1]);
            }

            // Sanitize for filesystem
            $companySafe = Str::slug($companyName, '_');
            $productSafe = Str::slug($productName, '_');

            // Limit filename length
            $productSafe = Str::limit($productSafe, 60, '');

            $relativePath = "products/{$companySafe}/{$productSafe}.{$ext}";

            Storage::disk('public')->put($relativePath, $imageData);

            return 'storage/' . $relativePath;
        } catch (\Throwable $e) {
            return null;
        }
    }

    /**
     * HTTP GET helper with cURL.
     */
    private function httpGet(string $url, array $extraHeaders = [], bool $binary = false): ?string
    {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS      => 5,
            CURLOPT_TIMEOUT        => 15,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_USERAGENT      => $this->userAgent,
            CURLOPT_HTTPHEADER     => array_merge([
                'Accept-Language: en-US,en;q=0.9',
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            ], array_map(fn($k, $v) => "{$k}: {$v}", array_keys($extraHeaders), $extraHeaders)),
            CURLOPT_ENCODING       => '',
        ]);

        $result   = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($result === false || $httpCode < 200 || $httpCode >= 400) {
            return null;
        }

        return $result;
    }

    /**
     * Load progress JSON from storage.
     */
    private function loadProgress(): array
    {
        if (file_exists($this->progressFile)) {
            $data = json_decode(file_get_contents($this->progressFile), true);
            return $data ?? ['saved' => [], 'failed' => [], 'total_saved' => 0, 'total_failed' => 0];
        }
        return ['saved' => [], 'failed' => [], 'total_saved' => 0, 'total_failed' => 0];
    }

    /**
     * Save progress JSON to storage.
     */
    private function saveProgress(array $progress): void
    {
        file_put_contents($this->progressFile, json_encode($progress, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}
