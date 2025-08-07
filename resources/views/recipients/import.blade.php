@extends('layouts.app')

@section('title', 'Import Data Penerima')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4"> <h4>Import Data Penerima dari Excel</h4> <a href="{{ route('recipients.index') }}" class="btn btn-secondary"> <i class="fas fa-arrow-left me-2"></i>Kembali </a> </div> <div class="card shadow"> <div class="card-body"> @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('recipients.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="file" class="form-label">Pilih File Excel</label>
            <input type="file" name="file" id="file" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-file-import me-2"></i>Import
        </button>
    </form>
</div>
</div> @endsection
