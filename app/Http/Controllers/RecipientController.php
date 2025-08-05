<?php

namespace App\Http\Controllers;

use App\Models\Recipient;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;

class RecipientController extends Controller
{
    public function index()
    {
        $recipients = Recipient::paginate(20);
        return view('recipients.index', compact('recipients'));
    }

    public function create()
    {
        return view('recipients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'child_name' => 'required|string|max:255',
            'parent_name' => 'required|string|max:255',
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'school_level' => 'required|string|max:255',
            'school_name' => 'required|string|max:255',
            'address' => 'required|string',
            'class' => 'required|string|max:255',
            'shoe_size' => 'required|string|max:10',
            'shirt_size' => 'required|string|max:10',
        ]);

        // Generate unique QR code
        $qrCode = $this->generateUniqueQrCode();

        $recipient = Recipient::create(array_merge($request->all(), [
            'qr_code' => $qrCode
        ]));

        return redirect()->route('recipients.index')
            ->with('success', 'Data penerima berhasil ditambahkan dengan QR Code: ' . $qrCode);
    }

    public function show(Recipient $recipient)
    {
        return view('recipients.show', compact('recipient'));
    }

    public function edit(Recipient $recipient)
    {
        return view('recipients.edit', compact('recipient'));
    }

    public function update(Request $request, Recipient $recipient)
    {
        $request->validate([
            'child_name' => 'required|string|max:255',
            'parent_name' => 'required|string|max:255',
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'school_level' => 'required|string|max:255',
            'school_name' => 'required|string|max:255',
            'address' => 'required|string',
            'class' => 'required|string|max:255',
            'shoe_size' => 'required|string|max:10',
            'shirt_size' => 'required|string|max:10',
        ]);

        $recipient->update($request->all());

        return redirect()->route('recipients.index')
            ->with('success', 'Data penerima berhasil diperbarui');
    }

    public function destroy(Recipient $recipient)
    {
        $recipient->delete();
        return redirect()->route('recipients.index')
            ->with('success', 'Data penerima berhasil dihapus');
    }

    public function generateQrCode(Recipient $recipient)
    {
        $encryptedCode = base64_encode($recipient->qr_code . '|' . $recipient->id);

        $qrCode = QrCode::size(200)
            ->format('png')
            ->generate($encryptedCode);

        return response($qrCode, 200)
            ->header('Content-Type', 'image/png');
    }

    public function printQrCode(Recipient $recipient)
    {
        $encryptedCode = base64_encode($recipient->qr_code . '|' . $recipient->id);

        $pdf = Pdf::loadView('recipients.qr-print', compact('recipient', 'encryptedCode'));

        return $pdf->download('qr-code-' . $recipient->qr_code . '.pdf');
    }

    public function scanQr()
    {
        return view('recipients.scan');
    }

    public function verifyQr(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|string'
        ]);

        try {
            $decoded = base64_decode($request->qr_code);
            $parts = explode('|', $decoded);

            if (count($parts) !== 2) {
                return response()->json(['error' => 'QR Code tidak valid'], 400);
            }

            $qrCode = $parts[0];
            $recipientId = $parts[1];

            $recipient = Recipient::where('qr_code', $qrCode)
                ->where('id', $recipientId)
                ->first();

            if (!$recipient) {
                return response()->json(['error' => 'QR Code tidak ditemukan'], 404);
            }

            return response()->json([
                'success' => true,
                'recipient' => $recipient,
                'status' => $recipient->distribution_status
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'QR Code tidak valid'], 400);
        }
    }

    public function distribute(Request $request, Recipient $recipient)
    {
        $request->validate([
            'uniform_received' => 'boolean',
            'shoes_received' => 'boolean',
            'bag_received' => 'boolean',
        ]);

        $recipient->update([
            'uniform_received' => $request->boolean('uniform_received'),
            'shoes_received' => $request->boolean('shoes_received'),
            'bag_received' => $request->boolean('bag_received'),
        ]);

        // Check if all items are distributed
        if ($recipient->isFullyDistributed()) {
            $recipient->update([
                'is_distributed' => true,
                'distributed_at' => now()
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Status penyaluran berhasil diperbarui',
            'is_fully_distributed' => $recipient->isFullyDistributed()
        ]);
    }

    public function generateReceipt(Recipient $recipient)
    {
        if (!$recipient->is_distributed) {
            return redirect()->back()->with('error', 'Penyaluran belum selesai');
        }

        $encryptedCode = base64_encode($recipient->qr_code . '|' . $recipient->id);

        $pdf = Pdf::loadView('recipients.receipt', compact('recipient', 'encryptedCode'));

        return $pdf->download('bukti-penerimaan-' . $recipient->qr_code . '.pdf');
    }

    private function generateUniqueQrCode()
    {
        do {
            // Get the next available number
            $lastRecipient = Recipient::orderBy('id', 'desc')->first();
            $nextNumber = $lastRecipient ? $lastRecipient->id + 1 : 1;

            $qrCode = 'CBP' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        } while (Recipient::where('qr_code', $qrCode)->exists());

        return $qrCode;
    }
}
