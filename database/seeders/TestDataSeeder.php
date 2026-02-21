<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Customer;
use App\Models\CustomerTag;
use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\Inventory;
use App\Models\Sale;
use App\Models\SaleItem;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        // Get the admin user (created earlier)
        $user = User::where('email', 'ashley@ashbrooke.com')->first();
        
        if (!$user) {
            $this->command->error('Admin user not found. Please create admin user first.');
            return;
        }

        // Create customer tags
        $vipTag = CustomerTag::create([
            'user_id' => $user->id,
            'name' => 'VIP',
            'color' => '#E91E63',
            'is_system' => true
        ]);

        // Create customers
        $customers = [];
        $customers[] = Customer::create([
            'user_id' => $user->id,
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email' => 'jane@example.com',
            'phone' => '555-1234',
            'city' => 'Dallas',
            'state' => 'TX',
            'how_met' => 'Party'
        ]);
        
        $customers[] = Customer::create([
            'user_id' => $user->id,
            'first_name' => 'Sarah',
            'last_name' => 'Smith',
            'email' => 'sarah@example.com',
            'phone' => '555-5678',
            'city' => 'Austin',
            'state' => 'TX',
            'how_met' => 'Referral'
        ]);

        // Tag first customer as VIP
        $customers[0]->tags()->attach($vipTag->id);

        // Create product categories
        $categories = [];
        $categories[] = ProductCategory::create([
            'user_id' => $user->id,
            'name' => 'Skincare',
            'description' => 'Skincare products',
            'is_system' => true
        ]);
        
        $categories[] = ProductCategory::create([
            'user_id' => $user->id,
            'name' => 'Makeup',
            'description' => 'Color cosmetics',
            'is_system' => true
        ]);

        // Create products
        $products = [];
        $products[] = Product::create([
            'user_id' => $user->id,
            'category_id' => $categories[0]->id,
            'name' => 'TimeWise Foundation',
            'sku' => 'TW-FOUND-001',
            'description' => 'Age-fighting foundation',
            'base_cost' => 15.00,
            'base_retail_price' => 30.00
        ]);
        
        $products[] = Product::create([
            'user_id' => $user->id,
            'category_id' => $categories[1]->id,
            'name' => 'Lipstick - Pink',
            'sku' => 'LIP-PINK-001',
            'description' => 'Long-lasting lipstick',
            'base_cost' => 8.00,
            'base_retail_price' => 16.00
        ]);

        // Add inventory
        foreach ($products as $product) {
            Inventory::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'quantity' => 10,
                'cost_per_unit' => $product->base_cost,
                'tax_paid_per_unit' => 0.50,
                'retail_price' => $product->base_retail_price,
                'low_stock_threshold' => 3
            ]);
        }

        // Create sales
        foreach ($customers as $index => $customer) {
            $sale = Sale::create([
                'user_id' => $user->id,
                'customer_id' => $customer->id,
                'sale_number' => 'SALE-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                'sale_type' => $index === 0 ? 'party' : 'retail',
                'subtotal' => 46.00,
                'tax_amount' => 3.68,
                'total_amount' => 49.68,
                'payment_status' => 'paid',
                'payment_method' => 'cash'
            ]);

            // Add sale items
            SaleItem::create([
                'sale_id' => $sale->id,
                'product_id' => $products[0]->id,
                'quantity' => 1,
                'unit_cost' => 15.00,
                'unit_price' => 30.00,
                'subtotal' => 30.00
            ]);
            
            SaleItem::create([
                'sale_id' => $sale->id,
                'product_id' => $products[1]->id,
                'quantity' => 1,
                'unit_cost' => 8.00,
                'unit_price' => 16.00,
                'subtotal' => 16.00
            ]);
        }

        $this->command->info('Test data created successfully!');
        $this->command->info('To remove test data, run: php artisan test:clear');
    }
}
