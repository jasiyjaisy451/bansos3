<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\RecipientImport;
use Maatwebsite\Excel\Facades\Excel;

class RecipientImportController extends Controller
{
    public function form()
    {
        return view('recipients.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new RecipientImport, $request->file('file'));

        return back()->with('success', 'Data berhasil diimpor!');
    }
}

