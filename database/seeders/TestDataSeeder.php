<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Customer;
use App\Models\CustomerTag;
use App\Models\CustomerNote;
use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\Inventory;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\SaleReturn;
use App\Models\ReturnItem;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        // Get the admin user
        $admin = User::where('email', 'ashley@ashbrooke.com')->first();
        
        if (!$admin) {
            $this->command->error('Admin user not found. Please create admin user first.');
            return;
        }

        // Create consultants
        $consultant1 = User::create([
            'name' => 'Emily Johnson',
            'email' => 'emily@example.com',
            'password' => Hash::make('password123'),
            'role' => 'consultant',
            'phone' => '555-9001',
            'recruited_by' => $admin->id,
            'status' => 'active',
        ]);

        $consultant2 = User::create([
            'name' => 'Rachel Martinez',
            'email' => 'rachel@example.com',
            'password' => Hash::make('password123'),
            'role' => 'consultant',
            'phone' => '555-9002',
            'recruited_by' => $admin->id,
            'status' => 'active',
        ]);

        // Create customer tags
        $vipTag = CustomerTag::create([
            'user_id' => $admin->id,
            'name' => 'VIP',
            'color' => '#E91E63',
            'is_system' => true
        ]);

        $hostessTag = CustomerTag::create([
            'user_id' => $admin->id,
            'name' => 'Hostess',
            'color' => '#9C27B0',
            'is_system' => false
        ]);

        // Create 10 customers
        $customers = [
            ['first_name' => 'Jane', 'last_name' => 'Doe', 'email' => 'jane@example.com', 'phone' => '555-1234', 'city' => 'Dallas', 'state' => 'TX', 'how_met' => 'Party', 'recruiting_interest' => true],
            ['first_name' => 'Sarah', 'last_name' => 'Smith', 'email' => 'sarah@example.com', 'phone' => '555-5678', 'city' => 'Austin', 'state' => 'TX', 'how_met' => 'Referral'],
            ['first_name' => 'Maria', 'last_name' => 'Garcia', 'email' => 'maria@example.com', 'phone' => '555-2345', 'city' => 'Houston', 'state' => 'TX', 'how_met' => 'Social Media', 'recruiting_interest' => true],
            ['first_name' => 'Lisa', 'last_name' => 'Brown', 'email' => 'lisa@example.com', 'phone' => '555-3456', 'city' => 'San Antonio', 'state' => 'TX', 'how_met' => 'Party'],
            ['first_name' => 'Jennifer', 'last_name' => 'Wilson', 'email' => 'jennifer@example.com', 'phone' => '555-4567', 'city' => 'Fort Worth', 'state' => 'TX', 'how_met' => 'Direct Contact', 'converted_to_user_id' => $consultant1->id],
            ['first_name' => 'Amanda', 'last_name' => 'Taylor', 'email' => 'amanda@example.com', 'phone' => '555-5679', 'city' => 'Plano', 'state' => 'TX', 'how_met' => 'Referral'],
            ['first_name' => 'Michelle', 'last_name' => 'Anderson', 'email' => 'michelle@example.com', 'phone' => '555-6789', 'city' => 'Arlington', 'state' => 'TX', 'how_met' => 'Party', 'recruiting_interest' => true],
            ['first_name' => 'Jessica', 'last_name' => 'Thomas', 'email' => 'jessica@example.com', 'phone' => '555-7890', 'city' => 'Irving', 'state' => 'TX', 'how_met' => 'Social Media'],
            ['first_name' => 'Ashley', 'last_name' => 'Moore', 'email' => 'ashley.m@example.com', 'phone' => '555-8901', 'city' => 'Frisco', 'state' => 'TX', 'how_met' => 'Referral', 'converted_to_user_id' => $consultant2->id],
            ['first_name' => 'Stephanie', 'last_name' => 'Jackson', 'email' => 'stephanie@example.com', 'phone' => '555-9012', 'city' => 'McKinney', 'state' => 'TX', 'how_met' => 'Direct Contact'],
        ];

        $customerModels = [];
        foreach ($customers as $customerData) {
            $customer = Customer::create(array_merge(['user_id' => $admin->id], $customerData));
            $customerModels[] = $customer;
        }

        // Tag some customers
        $customerModels[0]->tags()->attach($vipTag->id);
        $customerModels[3]->tags()->attach([$vipTag->id, $hostessTag->id]);
        $customerModels[6]->tags()->attach($hostessTag->id);

        // Add customer notes
        CustomerNote::create([
            'customer_id' => $customerModels[0]->id,
            'user_id' => $admin->id,
            'note' => 'Loves the TimeWise line. Interested in becoming a consultant!',
        ]);

        CustomerNote::create([
            'customer_id' => $customerModels[0]->id,
            'user_id' => $admin->id,
            'note' => '📞 Call: Discussed business opportunity. Very interested!',
        ]);

        CustomerNote::create([
            'customer_id' => $customerModels[2]->id,
            'user_id' => $admin->id,
            'note' => 'Asked about joining Mary Kay. Sent her info packet.',
        ]);

        CustomerNote::create([
            'customer_id' => $customerModels[3]->id,
            'user_id' => $admin->id,
            'note' => 'Hosted amazing party with 8 guests. Great hostess!',
        ]);

        CustomerNote::create([
            'customer_id' => $customerModels[4]->id,
            'user_id' => $admin->id,
            'note' => 'Converted to consultant! Now Emily Johnson.',
        ]);

        CustomerNote::create([
            'customer_id' => $customerModels[6]->id,
            'user_id' => $admin->id,
            'note' => 'Very interested in business opportunity. Following up next week.',
        ]);

        CustomerNote::create([
            'customer_id' => $customerModels[8]->id,
            'user_id' => $admin->id,
            'note' => 'Converted to consultant! Now Rachel Martinez.',
        ]);

        // Create product categories
        $categories = [];
        $categories[] = ProductCategory::create([
            'user_id' => $admin->id,
            'name' => 'Skincare',
            'description' => 'Skincare products',
            'is_system' => true
        ]);
        
        $categories[] = ProductCategory::create([
            'user_id' => $admin->id,
            'name' => 'Makeup',
            'description' => 'Color cosmetics',
            'is_system' => true
        ]);

        $categories[] = ProductCategory::create([
            'user_id' => $admin->id,
            'name' => 'Fragrance',
            'description' => 'Perfumes and body sprays',
            'is_system' => false
        ]);

        // Create products
        $products = [];
        $products[] = Product::create([
            'user_id' => $admin->id,
            'category_id' => $categories[0]->id,
            'name' => 'TimeWise Foundation',
            'sku' => 'TW-FOUND-001',
            'description' => 'Age-fighting foundation',
            'base_cost' => 15.00,
            'base_retail_price' => 30.00
        ]);
        
        $products[] = Product::create([
            'user_id' => $admin->id,
            'category_id' => $categories[1]->id,
            'name' => 'Lipstick - Pink Passion',
            'sku' => 'LIP-PINK-001',
            'description' => 'Long-lasting lipstick',
            'base_cost' => 8.00,
            'base_retail_price' => 16.00
        ]);

        $products[] = Product::create([
            'user_id' => $admin->id,
            'category_id' => $categories[0]->id,
            'name' => 'Miracle Set',
            'sku' => 'MIR-SET-001',
            'description' => 'Complete skincare system',
            'base_cost' => 45.00,
            'base_retail_price' => 90.00
        ]);

        $products[] = Product::create([
            'user_id' => $admin->id,
            'category_id' => $categories[1]->id,
            'name' => 'Mascara - Ultimate',
            'sku' => 'MASC-ULT-001',
            'description' => 'Volumizing mascara',
            'base_cost' => 10.00,
            'base_retail_price' => 20.00
        ]);

        $products[] = Product::create([
            'user_id' => $admin->id,
            'category_id' => $categories[2]->id,
            'name' => 'Bella Belara Perfume',
            'sku' => 'FRAG-BB-001',
            'description' => 'Floral fragrance',
            'base_cost' => 20.00,
            'base_retail_price' => 40.00
        ]);

        $products[] = Product::create([
            'user_id' => $admin->id,
            'category_id' => $categories[1]->id,
            'name' => 'Eye Shadow Palette',
            'sku' => 'EYE-PAL-001',
            'description' => '8-color palette',
            'base_cost' => 18.00,
            'base_retail_price' => 36.00
        ]);

        // Add inventory
        foreach ($products as $product) {
            Inventory::create([
                'user_id' => $admin->id,
                'product_id' => $product->id,
                'quantity' => rand(5, 25),
                'cost_per_unit' => $product->base_cost,
                'tax_paid_per_unit' => 0.50,
                'retail_price' => $product->base_retail_price,
                'low_stock_threshold' => 3
            ]);
        }

        // Create sales with variety
        $saleTypes = ['direct', 'party', 'online'];
        $paymentMethods = ['cash', 'card', 'venmo', 'paypal'];
        $saleNumber = 1;

        // Create 15 sales
        for ($i = 0; $i < 15; $i++) {
            $customer = $customerModels[array_rand($customerModels)];
            $saleType = $saleTypes[array_rand($saleTypes)];
            $paymentMethod = $paymentMethods[array_rand($paymentMethods)];
            
            // Random 1-4 products per sale
            $numItems = rand(1, 4);
            $subtotal = 0;
            $items = [];
            
            for ($j = 0; $j < $numItems; $j++) {
                $product = $products[array_rand($products)];
                $quantity = rand(1, 3);
                $unitPrice = $product->base_retail_price;
                $itemSubtotal = $quantity * $unitPrice;
                $subtotal += $itemSubtotal;
                
                $items[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'subtotal' => $itemSubtotal
                ];
            }
            
            $taxAmount = $subtotal * 0.0825;
            $shippingAmount = $saleType === 'online' ? rand(5, 15) : 0;
            $totalAmount = $subtotal + $taxAmount + $shippingAmount;
            
            $sale = Sale::create([
                'user_id' => $admin->id,
                'customer_id' => $customer->id,
                'sale_number' => str_pad($saleNumber++, 4, '0', STR_PAD_LEFT),
                'sale_type' => $saleType,
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'shipping_amount' => $shippingAmount,
                'total_amount' => $totalAmount,
                'payment_status' => 'paid',
                'payment_method' => $paymentMethod,
                'created_at' => now()->subDays(rand(1, 60)),
            ]);

            foreach ($items as $item) {
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product']->id,
                    'quantity' => $item['quantity'],
                    'unit_cost' => $item['product']->base_cost,
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $item['subtotal'],
                ]);
            }
        }

        // Create 2 returns
        $returnSales = Sale::where('user_id', $admin->id)->take(2)->get();
        foreach ($returnSales as $returnSale) {
            $returnItem = $returnSale->items->first();
            $refundAmount = $returnItem->unit_price * 1;
            
            $return = SaleReturn::create([
                'sale_id' => $returnSale->id,
                'user_id' => $admin->id,
                'customer_id' => $returnSale->customer_id,
                'return_number' => 'RET-' . str_pad(SaleReturn::count() + 1, 3, '0', STR_PAD_LEFT),
                'total_amount' => $refundAmount,
                'restore_inventory' => true,
                'reason' => 'Customer changed mind about color',
                'status' => 'completed',
                'returned_at' => now()->subDays(rand(1, 30)),
            ]);

            ReturnItem::create([
                'return_id' => $return->id,
                'sale_item_id' => $returnItem->id,
                'product_id' => $returnItem->product_id,
                'quantity' => 1,
                'refund_amount' => $refundAmount,
            ]);
        }

        $this->command->info('Test data created successfully!');
        $this->command->info('- 1 Admin: ashley@ashbrooke.com');
        $this->command->info('- 2 Consultants: emily@example.com, rachel@example.com (converted from customers)');
        $this->command->info('- 10 Customers (3 showing recruiting interest, 2 already converted)');
        $this->command->info('- Customer tags and notes showing recruiting pipeline');
        $this->command->info('- 6 Products across 3 categories');
        $this->command->info('- 15 Sales (direct, party, online)');
        $this->command->info('- 2 Returns');
        $this->command->info('To remove test data, run: php artisan test:clear');
    }
}
