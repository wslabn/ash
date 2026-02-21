<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Sale;
use App\Models\SaleItem;
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

        DB::beginTransaction();
        
        try {
            // Delete in correct order (respecting foreign keys)
            $this->info('Deleting sale items...');
            SaleItem::truncate();
            
            $this->info('Deleting sales...');
            Sale::truncate();
            
            $this->info('Deleting customer tags...');
            DB::table('customer_tag_pivot')->truncate();
            CustomerTag::truncate();
            
            $this->info('Deleting customers...');
            Customer::truncate();
            
            $this->info('Deleting inventory...');
            Inventory::truncate();
            
            $this->info('Deleting products...');
            Product::truncate();
            
            $this->info('Deleting product categories...');
            ProductCategory::truncate();
            
            DB::commit();
            
            $this->info('✅ All test data cleared successfully!');
            $this->info('Admin user preserved.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('Error clearing data: ' . $e->getMessage());
        }
    }
}
