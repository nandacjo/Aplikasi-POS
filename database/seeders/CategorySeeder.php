<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run()
    {
        DB::table('categories')->insert([
            ['category_name' => 'Beras Premium'],
            ['category_name' => 'Minyak Goreng Kemasan'],
            ['category_name' => 'Gula Pasir'],
            ['category_name' => 'Tepung Terigu Serbaguna'],
            ['category_name' => 'Susu Bubuk'],
            ['category_name' => 'Mie Instan Pedas'],
            ['category_name' => 'Kopi Instan'],
            ['category_name' => 'Sayuran Segar'],
            ['category_name' => 'Bumbu Instan'],
            ['category_name' => 'Saus Sambal'],
            ['category_name' => 'Roti Tawar'],
            ['category_name' => 'Telur Ayam'],
            ['category_name' => 'Sarden Kalengan'],
            ['category_name' => 'Cokelat Batangan'],
            ['category_name' => 'Makanan Ringan'],
            ['category_name' => 'Kacang-Kacangan'],
            ['category_name' => 'Susu UHT'],
            ['category_name' => 'Pasta & Makaroni'],
            ['category_name' => 'Makanan Kaleng'],
            ['category_name' => 'Sabun Cuci Piring'],
        ]);
    }
}
