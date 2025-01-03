<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Menambahkan data pengguna Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // pastikan menggunakan Hash::make untuk enkripsi password
            'current_team_id' => null, // jika ada relasi tim, sesuaikan
            'profile_photo_path' => null, // opsional, jika ada foto profil
        ]);

        // Anda bisa menambahkan data pengguna lain jika diperlukan
        User::create([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'current_team_id' => null,
            'profile_photo_path' => null,
        ]);

        // Misalnya menambahkan lebih banyak data pengguna
        User::create([
            'name' => 'Kasir',
            'email' => 'kasir@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'current_team_id' => null,
            'profile_photo_path' => null,
        ]);
    }
}
