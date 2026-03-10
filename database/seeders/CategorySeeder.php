<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Shipping & Logistics
        $shipping = Category::create([
            'name' => 'Shipping & Logistics',
            'description' => 'Shipping and logistics solutions',
        ]);

        Subcategory::create([
            'category_id' => $shipping->id,
            'name' => 'Shipping Platforms',
            'description' => 'Shipping management platforms',
        ]);

        Subcategory::create([
            'category_id' => $shipping->id,
            'name' => 'Tracking Systems',
            'description' => 'Package tracking systems',
        ]);

        // E-Commerce
        $ecommerce = Category::create([
            'name' => 'E-Commerce',
            'description' => 'E-commerce platforms and tools',
        ]);

        Subcategory::create([
            'category_id' => $ecommerce->id,
            'name' => 'Store Builders',
            'description' => 'E-commerce store builders',
        ]);

        Subcategory::create([
            'category_id' => $ecommerce->id,
            'name' => 'Payment Gateways',
            'description' => 'Payment processing solutions',
        ]);

        // Website Builders
        $website = Category::create([
            'name' => 'Website Builders',
            'description' => 'Website building platforms',
        ]);

        Subcategory::create([
            'category_id' => $website->id,
            'name' => 'No-Code Builders',
            'description' => 'No-code website builders',
        ]);

        Subcategory::create([
            'category_id' => $website->id,
            'name' => 'CMS Platforms',
            'description' => 'Content management systems',
        ]);
    }
}
