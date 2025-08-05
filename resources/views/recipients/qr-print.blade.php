<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>QR Code - {{ $recipient->qr_code }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            text-align: center;
        }
        .qr-container {
            border: 2px solid #333;
            padding: 20px;
            margin: 20px auto;
            width: 300px;
            border-radius: 10px;
        }
        .header {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }
        .qr-code {
            margin: 20px 0;
        }
        .recipient-info {
            font-size: 12px;
            margin-top: 15px;
            text-align: left;
        }
        .recipient-info table {
            width: 100%;
            font-size: 11px;
        }
        .recipient-info td {
            padding: 2px 5px;
            vertical-align: top;
        }
        .qr-text {
            font-size: 16px;
            font-weight: bold;
            margin: 10px 0;
            color: #0071BC;
        }
        .footer {
            font-size: 10px;
            color: #666;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="qr-container">
        <div class="header">BAZMA PERTAMINA</div>
        <div class="header" style="font-size: 14px;">Bantuan Sosial Pendidikan</div>
        
        <div class="qr-code">
            <img src="data:image/png;base64,{{ base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(150)->generate($encryptedCode)) }}" alt="QR Code">
        </div>
        
        <div class="qr-text">{{ $recipient->qr_code }}</div>
        
        <div class="recipient-info">
            <table>
                <tr>
                    <td style="width: 35%;"><strong>Nama:</strong></td>
                    <td>{{ $recipient->child_name }}</td>
                </tr>
                <tr>
                    <td><strong>Orang Tua:</strong></td>
                    <td>{{ $recipient->parent_name }}</td>
                </tr>
                <tr>
                    <td><strong>Sekolah:</strong></td>
                    <td>{{ $recipient->school_name }}</td>
                </tr>
                <tr>
                    <td><strong>Kelas:</strong></td>
                    <td>{{ $recipient->class }}</td>
                </tr>
                <tr>
                    <td><strong>Ukuran:</strong></td>
                    <td>Sepatu {{ $recipient->shoe_size }}, Baju {{ $recipient->shirt_size }}</td>
                </tr>
            </table>
        </div>
        
        <div class="footer">
            Scan QR ini saat penyaluran bantuan<br>
            Program Cilincing - Jakarta Utara
        </div>
    </div>
</body>
</html>