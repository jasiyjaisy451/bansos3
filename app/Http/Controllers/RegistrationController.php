<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipient;

class RegistrationController extends Controller
{
    // Verifikasi QR di halaman registrasi
    public function verifyRegistrationQr(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|string'
        ]);

        $qrInput = $request->qr_code;

        // Cari data berdasarkan QR
        $recipient = Recipient::where('qr_code', $qrInput)->first();

        if (!$recipient) {
            return response()->json(['error' => 'QR Code tidak ditemukan'], 404);
        }

        // Kalau sudah terdaftar sebelumnya
        if ($recipient->registrasi) {
            return response()->json(['error' => 'Penerima sudah registrasi'], 400);
        }

        return response()->json([
            'success' => true,
            'recipient' => $recipient
        ]);
    }

    // Konfirmasi Registrasi
    public function confirmRegistration(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|string'
        ]);

        $recipient = Recipient::where('qr_code', $request->qr_code)->first();

        if (!$recipient) {
            return response()->json(['error' => 'QR Code tidak ditemukan'], 404);
        }

        if ($recipient->registered) {
            return response()->json(['error' => 'Penerima sudah registrasi'], 400);
        }

        $recipient->registrasi = true;
        $recipient->save();

        return response()->json(['success' => true, 'message' => 'Registrasi berhasil']);
    }
}

