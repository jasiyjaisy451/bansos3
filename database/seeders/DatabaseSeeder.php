<?php

namespace Database\Seeders;

use App\Models\Recipient;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user

        User::create([
            'name' => 'user',
            'email' => 'user@bansos.com',
            'role' => 'user', // default user biasa
            'password' => Hash::make('user123'),
        ]);


    }
}
