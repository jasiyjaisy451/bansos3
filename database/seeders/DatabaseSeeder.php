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
            'name' => 'Administrator',
            'email' => 'admin@bansos.com',
            'password' => Hash::make('password123'),
        ]);
        
        User::create([
            'name' => 'Operator',
            'email' => 'operator@bansos.com',
            'password' => Hash::make('operator123'),
        ]);

        // Create sample recipients for testing
        for ($i = 1; $i <= 10; $i++) {
            Recipient::create([
                'qr_code' => 'CBP' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'child_name' => 'Anak Contoh ' . $i,
                'parent_name' => 'Orang Tua ' . $i,
                'birth_place' => 'Jakarta',
                'birth_date' => '2010-01-' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'school_level' => 'SD',
                'school_name' => 'SDN ' . $i . ' Jakarta',
                'address' => 'Jl. Contoh No. ' . $i . ', Jakarta Utara',
                'class' => '5A',
                'shoe_size' => '35',
                'shirt_size' => 'M',
            ]);
        }
    }
}
