<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\CustomerTag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::factory()->create([
            'name' => 'Ashley Ashbrooke',
            'email' => 'ashley@ashbrooke.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);
        
        // Create default customer tags
        $tags = ['Lead', 'VIP', 'Showing Interest', 'Converted'];
        foreach ($tags as $tag) {
            CustomerTag::create([
                'user_id' => $admin->id,
                'name' => $tag,
                'color' => match($tag) {
                    'Lead' => 'blue',
                    'VIP' => 'purple',
                    'Showing Interest' => 'yellow',
                    'Converted' => 'green',
                    default => 'gray'
                }
            ]);
        }
    }
}
