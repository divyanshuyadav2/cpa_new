<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SyncProductSalts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:sync-salts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Safely sync product generic salts and formulations from database/update_product_salts.sql into the database';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $sqlPath = database_path('update_product_salts.sql');
        if (!File::exists($sqlPath)) {
            $this->error("SQL file not found at: {$sqlPath}");
            return 1;
        }

        $this->info("Syncing product generic salts and compositions into database...");
        DB::unprepared(File::get($sqlPath));
        
        $saltCount = DB::table('salts')->count();
        $compCount = DB::table('products')->whereNotNull('composition')->where('composition', '!=', '')->count();
        $linkedCount = DB::table('products')->whereNotNull('salt_id')->count();

        $this->info("Done! Total salts: {$saltCount}. Products with composition: {$compCount}. Products linked to salts: {$linkedCount}.");

        return 0;
    }
}
