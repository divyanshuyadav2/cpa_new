<?php
require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;
use App\Models\Company;

echo "=== PRODUCT IMAGE STATS ===\n";
echo "Total products: " . Product::count() . "\n";
echo "With image:     " . Product::whereNotNull('image')->where('image', '!=', '')->count() . "\n";
echo "Without image:  " . Product::where(function($q){ $q->whereNull('image')->orWhere('image', ''); })->count() . "\n";

echo "\n=== SAMPLE EXISTING IMAGE PATHS ===\n";
$withImages = Product::whereNotNull('image')->where('image', '!=', '')->with('company')->take(5)->get();
foreach ($withImages as $p) {
    echo "Name: " . $p->name . "\n";
    echo "Company: " . ($p->company->name ?? 'N/A') . "\n";
    echo "Image: " . $p->image . "\n\n";
}

echo "=== TOP 30 COMPANIES WITH PRODUCTS WITHOUT IMAGES ===\n";
$companies = Company::withCount(['products as no_image_count' => function($q){
    $q->where(function($q2){ $q2->whereNull('image')->orWhere('image', ''); });
}])->having('no_image_count', '>', 0)->orderByDesc('no_image_count')->take(30)->get();

foreach ($companies as $c) {
    echo $c->id . " | " . $c->name . " | missing: " . $c->no_image_count . "\n";
}
