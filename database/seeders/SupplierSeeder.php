<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class SupplierSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID'); // Menggunakan locale Indonesia

        for ($i = 0; $i < 20; $i++) {
            DB::table('suppliers')->insert([
                'name' => $faker->company, // Menggunakan perusahaan sebagai nama supplier
                'address' => $faker->address, // Alamat supplier
                'phone' => $faker->phoneNumber, // Nomor telepon supplier
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
