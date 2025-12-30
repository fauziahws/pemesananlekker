<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create users with different roles
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'superadmin',
        ]);

        User::create([
            'name' => 'Kasir',
            'email' => 'cashier@example.com',
            'password' => Hash::make('password'),
            'role' => 'cashier',
        ]);

        User::create([
            'name' => 'Customer',
            'email' => 'customer@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        // Create sample products
        $products = [
            [
                'name' => 'Nasi Goreng Spesial',
                'description' => 'Nasi goreng dengan ayam, telur, dan sayuran segar',
                'price' => 25000,
                'is_available' => true,
            ],
            [
                'name' => 'Mie Ayam Bakso',
                'description' => 'Mie ayam dengan bakso sapi dan pangsit goreng',
                'price' => 20000,
                'is_available' => true,
            ],
            [
                'name' => 'Sate Ayam',
                'description' => '10 tusuk sate ayam dengan bumbu kacang dan lontong',
                'price' => 30000,
                'is_available' => true,
            ],
            [
                'name' => 'Gado-Gado',
                'description' => 'Sayuran segar dengan bumbu kacang dan kerupuk',
                'price' => 18000,
                'is_available' => true,
            ],
            [
                'name' => 'Es Teh Manis',
                'description' => 'Teh manis dingin yang segar',
                'price' => 5000,
                'is_available' => true,
            ],
            [
                'name' => 'Es Jeruk',
                'description' => 'Jus jeruk segar dengan es batu',
                'price' => 8000,
                'is_available' => true,
            ],
            [
                'name' => 'Ayam Goreng Kremes',
                'description' => 'Ayam goreng renyah dengan nasi dan lalapan',
                'price' => 28000,
                'is_available' => true,
            ],
            [
                'name' => 'Cap Cay',
                'description' => 'Tumis sayuran beragam dengan saus spesial',
                'price' => 22000,
                'is_available' => true,
            ],
        ];

        foreach ($products as $index => $productData) {
            // Use picsum.photos for placeholder images
            $productData['image'] = 'products/sample-' . ($index + 1) . '.jpg';
            
            Product::create($productData);
        }

        $this->command->info('✓ Sample users created (admin@example.com, cashier@example.com, customer@example.com) - password: password');
        $this->command->info('✓ Sample products created');
        $this->command->warn('⚠ Product images are set to placeholder paths. Run "php artisan storage:link" and ensure images exist in storage/app/public/products/');
    }
}
