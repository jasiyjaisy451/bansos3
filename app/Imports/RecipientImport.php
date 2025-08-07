<?php

namespace App\Imports;

use App\Models\Recipient;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RecipientImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Recipient::create([
                'qr_code' => $row['qr_code'],
                'child_name' => $row['child_name'],
                'Ayah_name' => $row['ayah_name'],
                'Ibu_name' => $row['ibu_name'],
                'birth_place' => $row['birth_place'],
                'birth_date' => $row['birth_date'],
                'school_level' => $row['school_level'],
                'school_name' => $row['school_name'],
                'address' => $row['address'],
                'class' => $row['class'],
                'shoe_size' => $row['shoe_size'],
                'shirt_size' => $row['shirt_size'],
                'uniform_received' => filter_var($row['uniform_received'], FILTER_VALIDATE_BOOLEAN),
                'shoes_received' => filter_var($row['shoes_received'], FILTER_VALIDATE_BOOLEAN),
                'bag_received' => filter_var($row['bag_received'], FILTER_VALIDATE_BOOLEAN),
                'is_distributed' => filter_var($row['is_distributed'], FILTER_VALIDATE_BOOLEAN),
                'distributed_at' => $row['distributed_at'],
            ]);
        }
    }
}
