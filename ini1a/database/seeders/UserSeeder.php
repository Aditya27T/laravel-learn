<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Buat 10 pengguna dummy
        User::factory()->count(10)->create();

        // Tambah pengguna admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'), // Password default admin
            'role' => 'admin'
        ]);
    }
}
