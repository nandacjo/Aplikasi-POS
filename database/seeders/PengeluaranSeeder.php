<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PengeluaranSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID'); // Menggunakan locale Indonesia

        for ($i = 0; $i < 20; $i++) {
            DB::table('expenses')->insert([
                'description' => $faker->sentence, // Deskripsi pengeluaran acak
                'amount' => $faker->numberBetween(100000, 1000000), // Nominal pengeluaran acak antara 100.000 dan 1.000.000
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
