<?php

namespace Database\Seeders;

use App\Models\Recipient;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Array admin data
        User::create([
            'name' => 'Admin',
            'email' => 'admin@bansos.com',
            'password' => Hash::make('4dm1n!2025'),
        ]);


        // Tambah operator
        User::create([
            'name' => 'Operator',
            'email' => 'operator@bansos.com',
            'password' => Hash::make('Op3r@t0r!2025'),
        ]);

        // Buat 10 data penerima
        for ($i = 1; $i <= 10; $i++) {
            Recipient::create([
                'qr_code' => 'CBP' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'child_name' => 'Anak Contoh ' . $i,
                'Ayah_name' => 'Ayah ' . $i,
                'Ibu_name' => 'Ibu' . $i,
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
