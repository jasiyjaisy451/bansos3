<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Form Tanda Tangan - {{ $recipient->qr_code }}</title>
    <style>
        @page {
            margin: 2cm;
            size: A4;
        }
        
        body {
            font-family: 'Times New Roman', serif;
            margin: 0;
            padding: 0;
            font-size: 12pt;
            line-height: 1.4;
            color: #000;
        }
        
        .letterhead {
            text-align: center;
            border-bottom: 3px solid #000;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        
        .letterhead h1 {
            font-size: 18pt;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
        }
        
        .letterhead h2 {
            font-size: 16pt;
            font-weight: bold;
            margin: 5px 0;
            text-transform: uppercase;
        }
        
        .letterhead p {
            font-size: 11pt;
            margin: 2px 0;
        }
        
        .document-title {
            text-align: center;
            margin: 25px 0;
        }
        
        .document-title h3 {
            font-size: 14pt;
            font-weight: bold;
            text-decoration: underline;
            margin: 0;
            text-transform: uppercase;
        }
        
        .content {
            margin: 20px 0;
        }
        
        .recipient-info {
            background-color: #f9f9f9;
            border: 1px solid #000;
            padding: 15px;
            margin: 20px 0;
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        
        .data-table td {
            padding: 5px;
            vertical-align: top;
        }
        
        .data-table .label {
            width: 25%;
            font-weight: bold;
        }
        
        .data-table .colon {
            width: 3%;
            text-align: center;
        }
        
        .signature-section {
            margin-top: 50px;
        }
        
        .signature-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #000;
        }
        
        .signature-table th,
        .signature-table td {
            border: 1px solid #000;
            padding: 15px;
            text-align: center;
            vertical-align: top;
        }
        
        .signature-table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        
        .signature-space {
            height: 80px;
        }
        
        .instructions {
            margin: 20px 0;
            padding: 15px;
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 5px;
        }
        
        .qr-section {
            text-align: center;
            margin: 20px 0;
            border: 1px solid #000;
            padding: 15px;
        }
        
        .footer {
            margin-top: 30px;
            font-size: 10pt;
            text-align: center;
            border-top: 1px solid #000;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="letterhead">
        <h1>Yayasan Bazma</h1>
        <h2>Program Bantuan Sosial Pendidikan</h2>
        <p>Bekerjasama dengan PT Pertamina (Persero)</p>
        <p>Jl. Cilincing Raya, Jakarta Utara 14120</p>
        <p>Telp: (021) 4401234 | Email: info@bazma.org</p>
    </div>

    <div class="document-title">
        <h3>Form Tanda Tangan Penerimaan Bantuan</h3>
    </div>

    <div class="content">
        <div class="recipient-info">
            <h4 style="margin-top: 0;">Data Penerima Bantuan:</h4>
            <table class="data-table">
                <tr>
                    <td class="label">Kode QR</td>
                    <td class="colon">:</td>
                    <td><strong>{{ $recipient->qr_code }}</strong></td>
                </tr>
                <tr>
                    <td class="label">Nama Penerima</td>
                    <td class="colon">:</td>
                    <td>{{ $recipient->child_name }}</td>
                </tr>
                <tr>
                    <td class="label">Nama Orang Tua</td>
                    <td class="colon">:</td>
                    <td>{{ $recipient->parent_name }}</td>
                </tr>
                <tr>
                    <td class="label">Sekolah</td>
                    <td class="colon">:</td>
                    <td>{{ $recipient->school_name }} ({{ $recipient->school_level }})</td>
                </tr>
                <tr>
                    <td class="label">Kelas</td>
                    <td class="colon">:</td>
                    <td>{{ $recipient->class }}</td>
                </tr>
                <tr>
                    <td class="label">Tanggal Penyaluran</td>
                    <td class="colon">:</td>
                    <td>{{ $recipient->distributed_at->format('d F Y, H:i') }} WIB</td>
                </tr>
            </table>
        </div>

        <div class="instructions">
            <h4 style="margin-top: 0;">Petunjuk Pengisian:</h4>
            <ol>
                <li>Pastikan data penerima sudah benar</li>
                <li>Tanda tangani pada kolom yang tersedia</li>
                <li>Tulis nama lengkap dengan jelas</li>
                <li>Berikan tanggal dan waktu penandatanganan</li>
            </ol>
        </div>

        <div class="signature-section">
            <table class="signature-table">
                <thead>
                    <tr>
                        <th style="width: 50%;">Penerima Bantuan</th>
                        <th style="width: 50%;">Petugas Penyalur</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <p><strong>Tanda Tangan:</strong></p>
                            <div class="signature-space"></div>
                            <p><strong>Nama Lengkap:</strong></p>
                            <p>{{ $recipient->parent_name }}</p>
                            <br>
                            <p><strong>Tanggal:</strong> ________________</p>
                        </td>
                        <td>
                            <p><strong>Tanda Tangan:</strong></p>
                            <div class="signature-space"></div>
                            <p><strong>Nama Lengkap:</strong></p>
                            <p>_________________________</p>
                            <br>
                            <p><strong>Tanggal:</strong> ________________</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="qr-section">
            <p><strong>QR Code Verifikasi:</strong></p>
            <img src="data:image/png;base64,{{ base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(100)->generate($encryptedCode)) }}" alt="QR Code">
            <br>
            <small>{{ $recipient->qr_code }}</small>
        </div>
    </div>

    <div class="footer">
        <p><em>Form ini dicetak pada {{ now()->format('d F Y, H:i') }} WIB</em></p>
        <p><strong>Program Bantuan Sosial Pendidikan - Yayasan Bazma & PT Pertamina (Persero)</strong></p>
    </div>
</body>
</html>