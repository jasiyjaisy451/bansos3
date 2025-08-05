<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bukti Penerimaan Bansos - {{ $recipient->qr_code }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }
        .title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .subtitle {
            font-size: 14px;
            color: #666;
        }
        .content {
            margin-bottom: 30px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .info-table td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        .info-table .label {
            background-color: #f5f5f5;
            font-weight: bold;
            width: 30%;
        }
        .items-section {
            margin: 20px 0;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .items-table th,
        .items-table td {
            padding: 10px;
            border: 1px solid #333;
            text-align: center;
        }
        .items-table th {
            background-color: #333;
            color: white;
            font-weight: bold;
        }
        .qr-section {
            text-align: center;
            margin: 20px 0;
        }
        .signature-section {
            margin-top: 40px;
        }
        .signature-box {
            display: inline-block;
            width: 200px;
            text-align: center;
            margin: 0 20px;
        }
        .signature-line {
            border-top: 1px solid #333;
            margin-top: 60px;
            padding-top: 5px;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        .received-mark {
            color: #28a745;
            font-weight: bold;
        }
        .not-received-mark {
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">BAZMA PERTAMINA</div>
        <div class="title">BUKTI PENERIMAAN BANTUAN SOSIAL PENDIDIKAN</div>
        <div class="subtitle">Program Cilincing - Jakarta Utara</div>
    </div>

    <div class="content">
        <table class="info-table">
            <tr>
                <td class="label">Kode QR</td>
                <td><strong>{{ $recipient->qr_code }}</strong></td>
            </tr>
            <tr>
                <td class="label">Nama Anak</td>
                <td>{{ $recipient->child_name }}</td>
            </tr>
            <tr>
                <td class="label">Nama Orang Tua</td>
                <td>{{ $recipient->parent_name }}</td>
            </tr>
            <tr>
                <td class="label">Tempat, Tanggal Lahir</td>
                <td>{{ $recipient->birth_place }}, {{ $recipient->birth_date->format('d F Y') }}</td>
            </tr>
            <tr>
                <td class="label">Sekolah</td>
                <td>{{ $recipient->school_name }} ({{ $recipient->school_level }})</td>
            </tr>
            <tr>
                <td class="label">Kelas</td>
                <td>{{ $recipient->class }}</td>
            </tr>
            <tr>
                <td class="label">Alamat</td>
                <td>{{ $recipient->address }}</td>
            </tr>
            <tr>
                <td class="label">Ukuran Sepatu</td>
                <td>{{ $recipient->shoe_size }}</td>
            </tr>
            <tr>
                <td class="label">Ukuran Baju</td>
                <td>{{ $recipient->shirt_size }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal Penyaluran</td>
                <td>{{ $recipient->distributed_at->format('d F Y, H:i') }} WIB</td>
            </tr>
        </table>

        <div class="items-section">
            <h3>Daftar Barang yang Diterima:</h3>
            <table class="items-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis Barang</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Seragam Sekolah</td>
                        <td>
                            @if($recipient->uniform_received)
                                <span class="received-mark">✓ DITERIMA</span>
                            @else
                                <span class="not-received-mark">✗ BELUM</span>
                            @endif
                        </td>
                        <td>Ukuran: {{ $recipient->shirt_size }}</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Sepatu Sekolah</td>
                        <td>
                            @if($recipient->shoes_received)
                                <span class="received-mark">✓ DITERIMA</span>
                            @else
                                <span class="not-received-mark">✗ BELUM</span>
                            @endif
                        </td>
                        <td>Ukuran: {{ $recipient->shoe_size }}</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Tas Sekolah</td>
                        <td>
                            @if($recipient->bag_received)
                                <span class="received-mark">✓ DITERIMA</span>
                            @else
                                <span class="not-received-mark">✗ BELUM</span>
                            @endif
                        </td>
                        <td>-</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="qr-section">
            <p><strong>QR Code Verifikasi:</strong></p>
            <img src="data:image/png;base64,{{ base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(150)->generate($encryptedCode)) }}" alt="QR Code">
            <br>
            <small>{{ $recipient->qr_code }}</small>
        </div>

        <div class="signature-section">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 50%; text-align: center;">
                        <div class="signature-box">
                            <p><strong>Penerima/Orang Tua</strong></p>
                            <div class="signature-line">
                                {{ $recipient->parent_name }}
                            </div>
                        </div>
                    </td>
                    <td style="width: 50%; text-align: center;">
                        <div class="signature-box">
                            <p><strong>Petugas Penyalur</strong></p>
                            <div class="signature-line">
                                (.................................)
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="footer">
        <p>Dokumen ini dicetak secara otomatis pada {{ now()->format('d F Y, H:i') }} WIB</p>
        <p>Program Bantuan Sosial Pendidikan - Bazma Pertamina Cilincing</p>
        <p><em>Dokumen ini sah tanpa tanda tangan basah</em></p>
    </div>
</body>
</html>