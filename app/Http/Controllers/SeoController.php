<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Salt;
use Illuminate\Support\Str;

class SeoController extends Controller
{
    /** Placeholder salt names that should not get their own landing page. */
    public const GENERIC_SALTS = ['Pharmaceutical Formulation'];

    /**
     * A-Z index of every salt/composition we supply.
     */
    public function index()
    {
        $salts = Salt::withCount(['products' => fn ($q) => $q->where('is_active', true)])
            ->whereNotIn('name', self::GENERIC_SALTS)
            ->orderBy('name')
            ->get()
            ->filter(fn ($s) => $s->products_count > 0)
            ->groupBy(fn ($s) => strtoupper(substr($s->name, 0, 1)));

        return view('salts.index', compact('salts'));
    }

    /**
     * Landing page for one salt, e.g. /salts/12/atorvastatin-calcium.
     */
    public function show(int $id, ?string $slug = null)
    {
        $salt = Salt::findOrFail($id);
        abort_if(in_array($salt->name, self::GENERIC_SALTS, true), 404);

        $canonicalSlug = Str::slug($salt->name);
        if ($slug !== $canonicalSlug) {
            return redirect()->route('public.salts.show', [$salt->id, $canonicalSlug], 301);
        }

        $products = Product::with(['company', 'division'])
            ->where('salt_id', $salt->id)->where('is_active', true)
            ->orderBy('name')->paginate(24);
        abort_if($products->total() === 0, 404);

        $companies = Product::where('salt_id', $salt->id)->where('is_active', true)
            ->with('company')->get()->pluck('company.name')->filter()->unique()->values();

        $related = Salt::where('id', '!=', $salt->id)->whereNotIn('name', self::GENERIC_SALTS)
            ->whereHas('products', fn ($q) => $q->whereIn('company_id', Product::where('salt_id', $salt->id)->pluck('company_id')))
            ->inRandomOrder()->take(8)->get();

        return view('salts.show', compact('salt', 'products', 'companies', 'related'));
    }

    public function sitemap()
    {
        $urls = [
            [url('/'), null, '1.0'],
            [route('public.products.index'), null, '0.9'],
            [route('public.salts.index'), null, '0.9'],
            [route('about'), null, '0.5'],
        ];

        Salt::whereNotIn('name', self::GENERIC_SALTS)->whereHas('products', fn ($q) => $q->where('is_active', true))
            ->get()->each(function ($s) use (&$urls) {
                $urls[] = [route('public.salts.show', [$s->id, Str::slug($s->name)]), $s->updated_at, '0.8'];
            });

        Product::where('is_active', true)->get(['id', 'updated_at'])->each(function ($p) use (&$urls) {
            $urls[] = [route('public.products.show', $p->id), $p->updated_at, '0.7'];
        });

        return response()->view('seo.sitemap', compact('urls'))->header('Content-Type', 'application/xml');
    }

    public function robots()
    {
        $body = "User-agent: *\nDisallow: /admin\nDisallow: /pwa\nDisallow: /cart\nDisallow: /api\nDisallow: /*?search=\nDisallow: /*?page=\n\nSitemap: " . url('/sitemap.xml') . "\n";

        return response($body, 200, ['Content-Type' => 'text/plain']);
    }
}
