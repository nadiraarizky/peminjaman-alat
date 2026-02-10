<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat user baru
        User::create([
            'name' => 'Nadira',
            'email' => 'nadiraarizky12@gmail.com',
            'password' => Hash::make('password123') // password harus di-hash
        ]);
    }
}
