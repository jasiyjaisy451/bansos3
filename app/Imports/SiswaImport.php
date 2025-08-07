<?php

namespace App\Imports;

use App\Models\Siswa;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        $data = [];

        foreach ($rows as $row) {
            $data[] = [
                'nama' => $row['nama'],
                'email' => $row['email'],
                'telepon' => $row['telepon'],
                'alamat' => $row['alamat'],
                'umur' => $row['umur'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Siswa::insert($data);
    }
}
