@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Penerima
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalRecipients }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Sudah Menerima
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $distributedCount }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Belum Menerima
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingCount }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clock fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Progress
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                    {{ $totalRecipients > 0 ? round(($distributedCount / $totalRecipients) * 100) : 0 }}%
                                </div>
                            </div>
                            <div class="col">
                                <div class="progress progress-sm mr-2">
                                    <div class="progress-bar bg-info" role="progressbar" 
                                         style="width: {{ $totalRecipients > 0 ? ($distributedCount / $totalRecipients) * 100 : 0 }}%">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-chart-pie fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Statistik Penyaluran Barang</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <div class="mb-3">
                            <i class="fas fa-tshirt fa-3x text-primary mb-2"></i>
                            <h5>{{ $uniformCount }}</h5>
                            <small class="text-muted">Seragam</small>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="mb-3">
                            <i class="fas fa-shoe-prints fa-3x text-success mb-2"></i>
                            <h5>{{ $shoesCount }}</h5>
                            <small class="text-muted">Sepatu</small>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="mb-3">
                            <i class="fas fa-briefcase fa-3x text-warning mb-2"></i>
                            <h5>{{ $bagCount }}</h5>
                            <small class="text-muted">Tas</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Penyaluran Terbaru</h6>
            </div>
            <div class="card-body">
                @if($recentDistributions->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($recentDistributions as $recipient)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $recipient->child_name }}</strong><br>
                                    <small class="text-muted">{{ $recipient->qr_code }}</small>
                                </div>
                                <small class="text-muted">
                                    {{ $recipient->distributed_at->format('d/m/Y H:i') }}
                                </small>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted text-center">Belum ada penyaluran</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Aksi Cepat</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('recipients.create') }}" class="btn btn-primary btn-block">
                            <i class="fas fa-plus me-2"></i>
                            Tambah Penerima
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('recipients.scan') }}" class="btn btn-success btn-block">
                            <i class="fas fa-qrcode me-2"></i>
                            Scan QR Code
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('recipients.index') }}" class="btn btn-info btn-block">
                            <i class="fas fa-list me-2"></i>
                            Lihat Semua Data
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('recipients.report') }}" class="btn btn-warning btn-block" target="_blank">
                            <i class="fas fa-print me-2"></i>
                            Cetak Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection