<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Buat satu admin
        User::factory()->admin()->create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
        ]);

        // Buat satu user
        User::factory()->user()->create([
            'name' => 'User',
            'email' => 'user@gmail.com',
        ]);

        // Buat user biasa
        User::factory()->create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
        ]);

        User::factory(50)->create();
    }
}

