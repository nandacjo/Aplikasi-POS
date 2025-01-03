<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            ['product_name' => 'Beras Sederhana', 'id_category' => 1, 'brand_name' => 'Beras Merah', 'purchase_price' => 8000, 'discount' => 5, 'selling_price' => 8500, 'stock' => 50],
            ['product_name' => 'Minyak Goreng 1L', 'id_category' => 2, 'brand_name' => 'Tama', 'purchase_price' => 12000, 'discount' => 10, 'selling_price' => 13000, 'stock' => 30],
            ['product_name' => 'Gula Pasir 1kg', 'id_category' => 3, 'brand_name' => 'Gulaku', 'purchase_price' => 11000, 'discount' => 5, 'selling_price' => 11500, 'stock' => 40],
            ['product_name' => 'Tepung Terigu Cakra', 'id_category' => 4, 'brand_name' => 'Cakra', 'purchase_price' => 9000, 'discount' => 0, 'selling_price' => 9500, 'stock' => 20],
            ['product_name' => 'Susu Bubuk Dancow', 'id_category' => 5, 'brand_name' => 'Dancow', 'purchase_price' => 22000, 'discount' => 10, 'selling_price' => 24000, 'stock' => 25],
            ['product_name' => 'Mie Instan ABC', 'id_category' => 6, 'brand_name' => 'ABC', 'purchase_price' => 3000, 'discount' => 0, 'selling_price' => 3500, 'stock' => 100],
            ['product_name' => 'Kopi Bubuk Kapal Api', 'id_category' => 7, 'brand_name' => 'Kapal Api', 'purchase_price' => 25000, 'discount' => 0, 'selling_price' => 28000, 'stock' => 15],
            ['product_name' => 'Sayur Bayam Segar', 'id_category' => 8, 'brand_name' => 'Segar', 'purchase_price' => 5000, 'discount' => 0, 'selling_price' => 6000, 'stock' => 60],
            ['product_name' => 'Bumbu Rujak Instan', 'id_category' => 9, 'brand_name' => 'Rujak Instan', 'purchase_price' => 10000, 'discount' => 0, 'selling_price' => 12000, 'stock' => 35],
            ['product_name' => 'Saus Sambal ABC', 'id_category' => 10, 'brand_name' => 'ABC', 'purchase_price' => 8000, 'discount' => 0, 'selling_price' => 9000, 'stock' => 45],
            ['product_name' => 'Roti Tawar Kismis', 'id_category' => 11, 'brand_name' => 'Roti Merah', 'purchase_price' => 15000, 'discount' => 0, 'selling_price' => 17000, 'stock' => 30],
            ['product_name' => 'Telur Ayam Kampung', 'id_category' => 12, 'brand_name' => 'Kampung', 'purchase_price' => 24000, 'discount' => 0, 'selling_price' => 27000, 'stock' => 50],
            ['product_name' => 'Sarden Kalengan ABC', 'id_category' => 13, 'brand_name' => 'ABC', 'purchase_price' => 13000, 'discount' => 0, 'selling_price' => 15000, 'stock' => 40],
            ['product_name' => 'Cokelat Batangan Cadbury', 'id_category' => 14, 'brand_name' => 'Cadbury', 'purchase_price' => 12000, 'discount' => 5, 'selling_price' => 13000, 'stock' => 25],
            ['product_name' => 'Makanan Ringan Chitato', 'id_category' => 15, 'brand_name' => 'Chitato', 'purchase_price' => 5000, 'discount' => 0, 'selling_price' => 6000, 'stock' => 80],
            ['product_name' => 'Kacang Tanah Goreng', 'id_category' => 16, 'brand_name' => 'Kacang Tanah', 'purchase_price' => 6000, 'discount' => 0, 'selling_price' => 7000, 'stock' => 70],
            ['product_name' => 'Susu UHT Indomilk', 'id_category' => 17, 'brand_name' => 'Indomilk', 'purchase_price' => 10000, 'discount' => 0, 'selling_price' => 11000, 'stock' => 60],
            ['product_name' => 'Pasta Spaghetti', 'id_category' => 18, 'brand_name' => 'Pasta Merah', 'purchase_price' => 12000, 'discount' => 0, 'selling_price' => 13000, 'stock' => 20],
            ['product_name' => 'Makanan Kaleng Mackerel', 'id_category' => 19, 'brand_name' => 'Mackerel', 'purchase_price' => 15000, 'discount' => 0, 'selling_price' => 16000, 'stock' => 30],
            ['product_name' => 'Sabun Cuci Piring Sunlight', 'id_category' => 20, 'brand_name' => 'Sunlight', 'purchase_price' => 8000, 'discount' => 0, 'selling_price' => 9000, 'stock' => 50],
        ];

        // Menambahkan product_code yang berurutan
        foreach ($products as $index => $product) {
            DB::table('products')->insert(array_merge($product, [
                'product_code' => str_pad($index + 1, 6, '0', STR_PAD_LEFT) // Membuat kode produk berurutan dengan format 000001, 000002, dst.
            ]));
        }
    }
}
