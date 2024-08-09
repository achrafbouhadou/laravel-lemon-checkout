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
        Product::updateOrCreate(
            [
                'lemonsqueezy_variant_id' => '479269', 
            ],
            [
                'name' => 'Rich Dad Poor Dad',
                'description' => 'Rich Dad and Poor Dad. The best book ever.',
                'price' => 19.99,
            ]
        );
    }
}
