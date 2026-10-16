<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SyncProductImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:sync-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Safely sync product image paths from database/update_product_images.sql into the products table';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $sqlPath = database_path('update_product_images.sql');
        if (!File::exists($sqlPath)) {
            $this->error("SQL file not found at: {$sqlPath}");
            return 1;
        }

        $this->info("Syncing product image paths into database...");
        DB::unprepared(File::get($sqlPath));
        
        $count = DB::table('products')->whereNotNull('image')->where('image', '!=', '')->count();
        $this->info("Done! Currently {$count} products have active image paths in the database.");

        return 0;
    }
}

