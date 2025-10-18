<?php
// database/seeders/ProductSeeder.php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Wardah Lightening Serum',
                'description' => 'Serum pencerah wajah dengan Niacinamide. Kondisi 85% masih tersisa. Expired date Desember 2025.',
                'price' => 45000,
                'stock' => 5,
                'category' => 'skincare',
                'condition' => 'good',
            ],
            [
                'name' => 'Maybelline Fit Me Foundation',
                'description' => 'Foundation shade 220 Natural Beige. Baru dipakai 2x, masih 95%. No box.',
                'price' => 75000,
                'stock' => 3,
                'category' => 'makeup',
                'condition' => 'like_new',
            ],
            [
                'name' => 'Real Techniques Brush Set',
                'description' => 'Set brush makeup 5 pcs. Sudah dicuci bersih. Kondisi bulu masih bagus.',
                'price' => 120000,
                'stock' => 2,
                'category' => 'tools',
                'condition' => 'good',
            ],
            [
                'name' => 'The Body Shop Tea Tree Oil',
                'description' => 'Tea tree oil untuk jerawat. Sisa 60%. Expired 2026.',
                'price' => 50000,
                'stock' => 4,
                'category' => 'skincare',
                'condition' => 'fair',
            ],
            [
                'name' => 'Victoria Secret Perfume',
                'description' => 'Bombshell perfume 50ml. Sisa 70%, botol masih bagus.',
                'price' => 150000,
                'stock' => 2,
                'category' => 'fragrance',
                'condition' => 'good',
            ],
            [
                'name' => 'Pixy Lip Cream',
                'description' => 'Lip cream matte shade 02 Chic Rose. Dipakai 3x.',
                'price' => 25000,
                'stock' => 8,
                'category' => 'makeup',
                'condition' => 'like_new',
            ],
            [
                'name' => 'Innisfree Green Tea Toner',
                'description' => 'Toner green tea dari Innisfree. Sisa 80%, masih fresh.',
                'price' => 65000,
                'stock' => 3,
                'category' => 'skincare',
                'condition' => 'good',
            ],
            [
                'name' => 'Beauty Blender Original',
                'description' => 'Beauty blender pink original. Sudah dicuci. Tidak ada noda.',
                'price' => 95000,
                'stock' => 4,
                'category' => 'tools',
                'condition' => 'good',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}