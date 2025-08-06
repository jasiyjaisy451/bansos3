@extends('layouts.app')

@section('title', 'Data Penerima')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <a href="{{ route('recipients.report') }}" class="btn btn-warning me-2" target="_blank">
            <i class="fas fa-file-alt me-2"></i>Cetak Laporan
        </a>
    </div>

    <a href="{{ route('recipients.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Tambah Penerima
    </a>
</div>

<div class="card shadow">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>QR Code</th>
                        <th>Nama Anak</th>
                        <th>Nama Orang Tua</th>
                        <th>Sekolah</th>
                        <th>Kelas</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recipients as $recipient)
                        <tr>
                            <td>
                                <span class="badge bg-primary">{{ $recipient->qr_code }}</span>
                            </td>
                            <td>{{ $recipient->child_name }}</td>
                            <td>{{ $recipient->parent_name }}</td>
                            <td>{{ $recipient->school_name }}</td>
                            <td>{{ $recipient->class }}</td>
                            <td>
                                @if($recipient->is_distributed)
                                    <span class="badge bg-success">Sudah Menerima</span>
                                @else
                                    <span class="badge bg-warning">Belum Menerima</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('recipients.show', $recipient) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('recipients.edit', $recipient) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('recipients.qr-code', $recipient) }}" class="btn btn-sm btn-secondary" target="_blank">
                                        <i class="fas fa-qrcode"></i>
                                    </a>
                                    @if($recipient->is_distributed)
                                        <a href="{{ route('recipients.receipt', $recipient) }}" class="btn btn-sm btn-success">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                    @endif
                                    <form action="{{ route('recipients.destroy', $recipient) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada data penerima</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center">
            {{ $recipients->links() }}
        </div>
    </div>
</div>
@endsection
