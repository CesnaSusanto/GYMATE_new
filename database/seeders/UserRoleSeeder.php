<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(UserRoleSeeder::class); // Tambahkan baris ini
        // // // User Customer Service
        // User::create([
        //     'username' => 'cs.utama',
        //     'password' => Hash::make('password'),
        //     'role' => 'customer_service',
        // ]);

        // // User Personal Trainer
        // User::create([
        //     'username' => 'trainer.satu',
        //     'password' => Hash::make('password'),
        //     'role' => 'personal_trainer',
        // ]);

        // // User Pelanggan (default dari registrasi)
        // User::create([
        //     'username' => 'pelanggan.satu',
        //     'password' => Hash::make('password'),
        //     'role' => 'pelanggan', // Ini akan menjadi default jika user mendaftar
        // ]);

        User::factory()->create([
            'username' => 'cs',
            'password' => Hash::make('password123'),
            'role' => 'customer_service',
        ]);
        User::factory()->create([
            'username' => 'user',
            'password' => Hash::make('password123'),
            'role' => 'pelanggan',
        ]);
        User::factory()->create([
            'username' => 'pt',
            'password' => Hash::make('password123'),
            'role' => 'personal_trainer',
        ]);

        // $this->command->info('Users dengan role berbeda berhasil ditambahkan!');
    }
}