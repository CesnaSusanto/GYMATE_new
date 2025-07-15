<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'username' => 'cs',
        //     'password' => Hash::make('password123'),
        //     'role' => 'customer_service',
        // ]);
        // User::factory()->create([
        //     'username' => 'user',
        //     'password' => Hash::make('password123'),
        //     'role' => 'pelanggan',
        // ]);
        // User::factory()->create([
        //     'username' => 'pt',
        //     'password' => Hash::make('password123'),
        //     'role' => 'personal_trainer',
        // ]);
    }
}
