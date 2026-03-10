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
            'slug' => 'shipping-logistics',
            'description' => 'Shipping and logistics solutions',
        ]);

        Subcategory::create([
            'category_id' => $shipping->id,
            'name' => 'Shipping Platforms',
            'slug' => 'shipping-platforms',
            'description' => 'Shipping management platforms',
        ]);

        Subcategory::create([
            'category_id' => $shipping->id,
            'name' => 'Tracking Systems',
            'slug' => 'tracking-systems',
            'description' => 'Package tracking systems',
        ]);

        // E-Commerce
        $ecommerce = Category::create([
            'name' => 'E-Commerce',
            'slug' => 'e-commerce',
            'description' => 'E-commerce platforms and tools',
        ]);

        Subcategory::create([
            'category_id' => $ecommerce->id,
            'name' => 'Store Builders',
            'slug' => 'store-builders',
            'description' => 'E-commerce store builders',
        ]);

        Subcategory::create([
            'category_id' => $ecommerce->id,
            'name' => 'Payment Gateways',
            'slug' => 'payment-gateways',
            'description' => 'Payment processing solutions',
        ]);

        // Website Builders
        $website = Category::create([
            'name' => 'Website Builders',
            'slug' => 'website-builders',
            'description' => 'Website building platforms',
        ]);

        Subcategory::create([
            'category_id' => $website->id,
            'name' => 'No-Code Builders',
            'slug' => 'no-code-builders',
            'description' => 'No-code website builders',
        ]);

        Subcategory::create([
            'category_id' => $website->id,
            'name' => 'CMS Platforms',
            'slug' => 'cms-platforms',
            'description' => 'Content management systems',
        ]);
    }
}
