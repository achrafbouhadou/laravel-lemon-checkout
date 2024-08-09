<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Digital Product 1',
            'description' => 'Description of Digital Product 1',
            'price' => 19.99,
            'lemonsqueezy_variant_id' => '479269', // Use the real variant ID from you  LemonSqueezy panel
        ]);
    }
}
