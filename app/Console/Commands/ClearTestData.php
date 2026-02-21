<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Payment;
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\CustomerTag;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;

class ClearTestData extends Command
{
    protected $signature = 'test:clear';
    protected $description = 'Clear all test data (keeps admin user)';

    public function handle()
    {
        if (!$this->confirm('This will delete ALL customers, products, inventory, and sales. Continue?')) {
            $this->info('Cancelled.');
            return;
        }

        try {
            // Disable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            
            // Delete in any order
            $this->info('Clearing all test data...');
            DB::table('return_items')->truncate();
            DB::table('returns')->truncate();
            SaleItem::truncate();
            Payment::truncate();
            Invoice::truncate();
            Sale::truncate();
            DB::table('customer_tag_pivot')->truncate();
            CustomerTag::truncate();
            Customer::truncate();
            Inventory::truncate();
            DB::table('product_variants')->truncate();
            Product::truncate();
            ProductCategory::truncate();
            
            // Re-enable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            
            $this->info('✅ All test data cleared successfully!');
            $this->info('Admin user preserved.');
            
        } catch (\Exception $e) {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            $this->error('Error clearing data: ' . $e->getMessage());
        }
    }
}
