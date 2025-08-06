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
            // Try to decode base64 first (for scanned QR codes)
            $qrInput = $request->qr_code;
            $recipient = null;
            
            // Check if it's a base64 encoded QR code
            if (base64_decode($qrInput, true) !== false) {
                $decoded = base64_decode($qrInput);
                $parts = explode('|', $decoded);
                
                if (count($parts) === 2) {
                    $qrCode = $parts[0];
                    $recipientId = $parts[1];
                    
                    $recipient = Recipient::where('qr_code', $qrCode)
                        ->where('id', $recipientId)
                        ->first();
                }
            }
            
            // If not found, try direct QR code search
            if (!$recipient) {
                $recipient = Recipient::where('qr_code', $qrInput)->first();
            }

            if (!$recipient) {
                return response()->json(['error' => 'QR Code tidak ditemukan'], 404);
            }

            return response()->json([
                'success' => true,
                'recipient' => $recipient,
                'status' => $recipient->distribution_status
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'QR Code tidak valid: ' . $e->getMessage()], 400);
        }
    }

    public function distribute(Request $request, Recipient $recipient)
    {
        try {
            // Convert checkbox values to boolean
            $uniformReceived = $request->has('uniform_received') ? true : false;
            $shoesReceived = $request->has('shoes_received') ? true : false;
            $bagReceived = $request->has('bag_received') ? true : false;

            $recipient->update([
                'uniform_received' => $uniformReceived,
                'shoes_received' => $shoesReceived,
                'bag_received' => $bagReceived,
            ]);

            // Check if all items are distributed
            $recipient->refresh();
            if ($recipient->uniform_received && $recipient->shoes_received && $recipient->bag_received) {
                $recipient->update([
                    'is_distributed' => true,
                    'distributed_at' => now()
                ]);
            } else {
                $recipient->update([
                    'is_distributed' => false,
                    'distributed_at' => null
                ]);
            }

            $recipient->refresh();

            return response()->json([
                'success' => true,
                'message' => 'Status penyaluran berhasil diperbarui',
                'is_fully_distributed' => $recipient->is_distributed,
                'recipient' => $recipient
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage()
            ], 500);
        }
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

    public function generateSignatureForm(Recipient $recipient)
    {
        if (!$recipient->is_distributed) {
            return redirect()->back()->with('error', 'Penyaluran belum selesai');
        }

        $encryptedCode = base64_encode($recipient->qr_code . '|' . $recipient->id);

        $pdf = Pdf::loadView('recipients.signature-form', compact('recipient', 'encryptedCode'));

        return $pdf->download('form-tanda-tangan-' . $recipient->qr_code . '.pdf');
    }

    public function generateReport()
    {
        $totalRecipients = Recipient::count();
        $distributedCount = Recipient::where('is_distributed', true)->count();
        $pendingCount = $totalRecipients - $distributedCount;
        
        $uniformCount = Recipient::where('uniform_received', true)->count();
        $shoesCount = Recipient::where('shoes_received', true)->count();
        $bagCount = Recipient::where('bag_received', true)->count();
        
        $recipients = Recipient::orderBy('created_at', 'desc')->get();
        $distributedRecipients = Recipient::where('is_distributed', true)
            ->orderBy('distributed_at', 'desc')->get();

        $pdf = Pdf::loadView('recipients.report', compact(
            'totalRecipients',
            'distributedCount', 
            'pendingCount',
            'uniformCount',
            'shoesCount',
            'bagCount',
            'recipients',
            'distributedRecipients'
        ));

        return $pdf->download('laporan-bansos-pendidikan-' . date('Y-m-d') . '.pdf');
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
