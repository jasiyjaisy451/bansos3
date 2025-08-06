@extends('layouts.app')

@section('title', 'Detail Penerima')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Detail Penerima</h5>
                <span class="badge {{ $recipient->is_distributed ? 'bg-success' : 'bg-warning' }}">
                    {{ $recipient->distribution_status }}
                </span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>QR Code:</strong></td>
                                <td><span class="badge bg-primary">{{ $recipient->qr_code }}</span></td>
                            </tr>
                            <tr>
                                <td><strong>Nama Anak:</strong></td>
                                <td>{{ $recipient->child_name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Nama Orang Tua:</strong></td>
                                <td>{{ $recipient->parent_name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Tempat, Tanggal Lahir:</strong></td>
                                <td>{{ $recipient->birth_place }}, {{ $recipient->birth_date->format('d F Y') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Tingkat Sekolah:</strong></td>
                                <td>{{ $recipient->school_level }}</td>
                            </tr>
                            <tr>
                                <td><strong>Nama Sekolah:</strong></td>
                                <td>{{ $recipient->school_name }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Alamat:</strong></td>
                                <td>{{ $recipient->address }}</td>
                            </tr>
                            <tr>
                                <td><strong>Kelas:</strong></td>
                                <td>{{ $recipient->class }}</td>
                            </tr>
                            <tr>
                                <td><strong>Ukuran Sepatu:</strong></td>
                                <td>{{ $recipient->shoe_size }}</td>
                            </tr>
                            <tr>
                                <td><strong>Ukuran Baju:</strong></td>
                                <td>{{ $recipient->shirt_size }}</td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal Dibuat:</strong></td>
                                <td>{{ $recipient->created_at->format('d F Y, H:i') }}</td>
                            </tr>
                            @if($recipient->distributed_at)
                            <tr>
                                <td><strong>Tanggal Penyaluran:</strong></td>
                                <td>{{ $recipient->distributed_at->format('d F Y, H:i') }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <h6><strong>Status Penyaluran Barang:</strong></h6>
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <div class="p-3 border rounded {{ $recipient->uniform_received ? 'bg-success text-white' : 'bg-light' }}">
                                    <i class="fas fa-tshirt fa-2x mb-2"></i>
                                    <br>
                                    <strong>Seragam</strong>
                                    <br>
                                    <small>{{ $recipient->uniform_received ? 'Sudah Diterima' : 'Belum Diterima' }}</small>
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="p-3 border rounded {{ $recipient->shoes_received ? 'bg-success text-white' : 'bg-light' }}">
                                    <i class="fas fa-shoe-prints fa-2x mb-2"></i>
                                    <br>
                                    <strong>Sepatu</strong>
                                    <br>
                                    <small>{{ $recipient->shoes_received ? 'Sudah Diterima' : 'Belum Diterima' }}</small>
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="p-3 border rounded {{ $recipient->bag_received ? 'bg-success text-white' : 'bg-light' }}">
                                    <i class="fas fa-briefcase fa-2x mb-2"></i>
                                    <br>
                                    <strong>Tas</strong>
                                    <br>
                                    <small>{{ $recipient->bag_received ? 'Sudah Diterima' : 'Belum Diterima' }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('recipients.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    <div>
                        <a href="{{ route('recipients.edit', $recipient) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Edit
                        </a>
                        <a href="{{ route('recipients.qr-code', $recipient) }}" class="btn btn-info" target="_blank">
                            <i class="fas fa-qrcode me-2"></i>Lihat QR
                        </a>
                        @if($recipient->is_distributed)
                            <a href="{{ route('recipients.receipt', $recipient) }}" class="btn btn-success">
                                <i class="fas fa-file-pdf me-2"></i>Cetak Bukti
                            </a>
                            <a href="{{ route('recipients.signature', $recipient) }}" class="btn btn-warning">
                                <i class="fas fa-signature me-2"></i>Form TTD
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="mb-0">QR Code</h6>
            </div>
            <div class="card-body text-center">
                <img src="{{ route('recipients.qr-code', $recipient) }}" alt="QR Code" class="img-fluid mb-3" style="max-width: 200px;">
                <br>
                <strong>{{ $recipient->qr_code }}</strong>
                <br>
                <a href="{{ route('recipients.qr-print', $recipient) }}" class="btn btn-sm btn-outline-primary mt-2">
                    <i class="fas fa-download me-1"></i>Download QR
                </a>
            </div>
        </div>
    </div>
</div>
@endsection