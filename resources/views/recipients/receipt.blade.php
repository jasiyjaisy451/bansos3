<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bukti Penerimaan Bansos - {{ $recipient->qr_code }}</title>
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
        
        .document-number {
            text-align: center;
            margin-bottom: 25px;
            font-size: 11pt;
        }
        
        .content {
            margin: 20px 0;
        }
        
        .opening-text {
            text-align: justify;
            margin-bottom: 20px;
            text-indent: 30px;
        }
        
        .recipient-data {
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
        
        .items-section {
            margin: 25px 0;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        
        .items-table th,
        .items-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }
        
        .items-table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        
        .items-table .text-left {
            text-align: left;
        }
        
        .status-received {
            font-weight: bold;
            color: #000;
        }
        
        .closing-text {
            text-align: justify;
            margin: 25px 0;
            text-indent: 30px;
        }
        
        .signature-section {
            margin-top: 40px;
        }
        
        .signature-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .signature-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            padding: 10px;
        }
        
        .signature-box {
            margin: 20px 0;
        }
        
        .signature-line {
            border-bottom: 1px solid #000;
            height: 60px;
            margin: 10px 0;
        }
        
        .signature-name {
            font-weight: bold;
            margin-top: 5px;
        }
        
        .qr-section {
            text-align: center;
            margin: 20px 0;
            page-break-inside: avoid;
        }
        
        .footer {
            margin-top: 30px;
            font-size: 10pt;
            text-align: center;
            border-top: 1px solid #000;
            padding-top: 10px;
        }
        
        .date-location {
            text-align: right;
            margin: 20px 0;
        }
        
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
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
        <h3>Bukti Penerimaan Bantuan Sosial Pendidikan</h3>
    </div>
    
    <div class="document-number">
        Nomor: {{ $recipient->qr_code }}/BSP/{{ date('Y') }}
    </div>

    <div class="content">
        <div class="opening-text">
            Dengan ini menyatakan bahwa bantuan sosial pendidikan telah diterima oleh penerima manfaat dengan data sebagai berikut:
        </div>

        <div class="recipient-data">
            <table class="data-table">
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
                    <td class="label">Tempat, Tanggal Lahir</td>
                    <td class="colon">:</td>
                    <td>{{ $recipient->birth_place }}, {{ $recipient->birth_date->format('d F Y') }}</td>
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
                    <td class="label">Alamat</td>
                    <td class="colon">:</td>
                    <td>{{ $recipient->address }}</td>
                </tr>
            </table>
        </div>

        <div class="items-section">
            <p><strong>Dengan rincian bantuan yang diterima sebagai berikut:</strong></p>
            <table class="items-table">
                <thead>
                    <tr>
                        <th style="width: 10%;">No</th>
                        <th style="width: 40%;">Jenis Bantuan</th>
                        <th style="width: 20%;">Spesifikasi</th>
                        <th style="width: 15%;">Status</th>
                        <th style="width: 15%;">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td class="text-left">Seragam Sekolah</td>
                        <td>Ukuran {{ $recipient->shirt_size }}</td>
                        <td>
                            @if($recipient->uniform_received)
                                <span class="status-received">✓ DITERIMA</span>
                            @else
                                <span>BELUM</span>
                            @endif
                        </td>
                        <td>1 Set</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td class="text-left">Sepatu Sekolah</td>
                        <td>Ukuran {{ $recipient->shoe_size }}</td>
                        <td>
                            @if($recipient->shoes_received)
                                <span class="status-received">✓ DITERIMA</span>
                            @else
                                <span>BELUM</span>
                            @endif
                        </td>
                        <td>1 Pasang</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td class="text-left">Tas Sekolah</td>
                        <td>Standard</td>
                        <td>
                            @if($recipient->bag_received)
                                <span class="status-received">✓ DITERIMA</span>
                            @else
                                <span>BELUM</span>
                            @endif
                        </td>
                        <td>1 Buah</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="closing-text">
            Bantuan sosial pendidikan ini diberikan dalam rangka mendukung pendidikan anak Indonesia dan diharapkan dapat dimanfaatkan dengan sebaik-baiknya untuk keperluan sekolah.
        </div>

        <div class="date-location">
            Jakarta, {{ $recipient->distributed_at->format('d F Y') }}
        </div>

        <div class="signature-section">
            <table class="signature-table">
                <tr>
                    <td>
                        <div class="signature-box">
                            <p><strong>Penerima Bantuan</strong></p>
                            <div class="signature-line"></div>
                            <div class="signature-name">{{ $recipient->parent_name }}</div>
                            <p><small>(Orang Tua/Wali)</small></p>
                        </div>
                    </td>
                    <td>
                        <div class="signature-box">
                            <p><strong>Petugas Penyalur</strong></p>
                            <div class="signature-line"></div>
                            <div class="signature-name">(.............................)</div>
                            <p><small>(Nama & Tanda Tangan)</small></p>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="qr-section">
            <p><strong>Kode Verifikasi:</strong></p>
            <img src="data:image/png;base64,{{ base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(100)->generate($encryptedCode)) }}" alt="QR Code">
            <br>
            <small>{{ $recipient->qr_code }}</small>
        </div>
    </div>

    <div class="footer">
        <p><em>Dokumen ini dicetak secara otomatis pada {{ now()->format('d F Y, H:i') }} WIB</em></p>
        <p><strong>Program Bantuan Sosial Pendidikan - Yayasan Bazma & PT Pertamina (Persero)</strong></p>
    </div>
</body>
</html>