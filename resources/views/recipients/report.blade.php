<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Bantuan Sosial Pendidikan</title>
    <style>
        @page {
            margin: 2cm;
            size: A4;
        }
        
        body {
            font-family: 'Times New Roman', serif;
            margin: 0;
            padding: 0;
            font-size: 11pt;
            line-height: 1.3;
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
        
        .report-info {
            text-align: center;
            margin-bottom: 25px;
            font-size: 11pt;
        }
        
        .summary-section {
            margin: 20px 0;
        }
        
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        
        .summary-table th,
        .summary-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }
        
        .summary-table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        
        .summary-table .text-left {
            text-align: left;
        }
        
        .detail-section {
            margin: 25px 0;
            page-break-inside: avoid;
        }
        
        .detail-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-size: 9pt;
        }
        
        .detail-table th,
        .detail-table td {
            border: 1px solid #000;
            padding: 4px;
            text-align: center;
        }
        
        .detail-table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        
        .detail-table .text-left {
            text-align: left;
        }
        
        .status-distributed {
            color: #000;
            font-weight: bold;
        }
        
        .status-pending {
            color: #666;
        }
        
        .footer {
            margin-top: 30px;
            font-size: 10pt;
            text-align: center;
            border-top: 1px solid #000;
            padding-top: 10px;
        }
        
        .signature-section {
            margin-top: 40px;
            text-align: right;
        }
        
        .signature-box {
            display: inline-block;
            text-align: center;
            margin-top: 20px;
        }
        
        .signature-line {
            border-bottom: 1px solid #000;
            width: 200px;
            height: 60px;
            margin: 10px 0;
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
        <h3>Laporan Distribusi Bantuan Sosial Pendidikan</h3>
    </div>
    
    <div class="report-info">
        <p><strong>Periode:</strong> {{ date('d F Y') }}</p>
        <p><strong>Lokasi:</strong> Jakarta Utara</p>
    </div>

    <div class="summary-section">
        <h4>I. RINGKASAN DISTRIBUSI</h4>
        <table class="summary-table">
            <thead>
                <tr>
                    <th style="width: 40%;">Keterangan</th>
                    <th style="width: 20%;">Jumlah</th>
                    <th style="width: 20%;">Persentase</th>
                    <th style="width: 20%;">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-left">Total Penerima Terdaftar</td>
                    <td><strong>{{ $totalRecipients }}</strong></td>
                    <td>100%</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td class="text-left">Sudah Menerima Bantuan</td>
                    <td><strong>{{ $distributedCount }}</strong></td>
                    <td>{{ $totalRecipients > 0 ? round(($distributedCount / $totalRecipients) * 100, 1) : 0 }}%</td>
                    <td class="status-distributed">SELESAI</td>
                </tr>
                <tr>
                    <td class="text-left">Belum Menerima Bantuan</td>
                    <td><strong>{{ $pendingCount }}</strong></td>
                    <td>{{ $totalRecipients > 0 ? round(($pendingCount / $totalRecipients) * 100, 1) : 0 }}%</td>
                    <td class="status-pending">PENDING</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="summary-section">
        <h4>II. DISTRIBUSI PER JENIS BANTUAN</h4>
        <table class="summary-table">
            <thead>
                <tr>
                    <th style="width: 40%;">Jenis Bantuan</th>
                    <th style="width: 20%;">Terdistribusi</th>
                    <th style="width: 20%;">Persentase</th>
                    <th style="width: 20%;">Sisa</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-left">Seragam Sekolah</td>
                    <td><strong>{{ $uniformCount }}</strong></td>
                    <td>{{ $totalRecipients > 0 ? round(($uniformCount / $totalRecipients) * 100, 1) : 0 }}%</td>
                    <td>{{ $totalRecipients - $uniformCount }}</td>
                </tr>
                <tr>
                    <td class="text-left">Sepatu Sekolah</td>
                    <td><strong>{{ $shoesCount }}</strong></td>
                    <td>{{ $totalRecipients > 0 ? round(($shoesCount / $totalRecipients) * 100, 1) : 0 }}%</td>
                    <td>{{ $totalRecipients - $shoesCount }}</td>
                </tr>
                <tr>
                    <td class="text-left">Tas Sekolah</td>
                    <td><strong>{{ $bagCount }}</strong></td>
                    <td>{{ $totalRecipients > 0 ? round(($bagCount / $totalRecipients) * 100, 1) : 0 }}%</td>
                    <td>{{ $totalRecipients - $bagCount }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    @if($distributedRecipients->count() > 0)
    <div class="detail-section">
        <h4>III. DAFTAR PENERIMA YANG SUDAH MENERIMA BANTUAN</h4>
        <table class="detail-table">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 10%;">QR Code</th>
                    <th style="width: 20%;">Nama Anak</th>
                    <th style="width: 20%;">Nama Orang Tua</th>
                    <th style="width: 15%;">Sekolah</th>
                    <th style="width: 8%;">Kelas</th>
                    <th style="width: 7%;">Seragam</th>
                    <th style="width: 7%;">Sepatu</th>
                    <th style="width: 8%;">Tas</th>
                </tr>
            </thead>
            <tbody>
                @foreach($distributedRecipients as $index => $recipient)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $recipient->qr_code }}</td>
                    <td class="text-left">{{ $recipient->child_name }}</td>
                    <td class="text-left">{{ $recipient->parent_name }}</td>
                    <td class="text-left">{{ $recipient->school_name }}</td>
                    <td>{{ $recipient->class }}</td>
                    <td>{{ $recipient->uniform_received ? '✓' : '-' }}</td>
                    <td>{{ $recipient->shoes_received ? '✓' : '-' }}</td>
                    <td>{{ $recipient->bag_received ? '✓' : '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <div class="signature-section">
        <p>Jakarta, {{ date('d F Y') }}</p>
        <div class="signature-box">
            <p><strong>Koordinator Program</strong></p>
            <div class="signature-line"></div>
            <p><strong>(.............................)</strong></p>
            <p>Yayasan Bazma</p>
        </div>
    </div>

    <div class="footer">
        <p><em>Laporan ini dicetak secara otomatis pada {{ now()->format('d F Y, H:i') }} WIB</em></p>
        <p><strong>Program Bantuan Sosial Pendidikan - Yayasan Bazma & PT Pertamina (Persero)</strong></p>
    </div>
</body>
</html>