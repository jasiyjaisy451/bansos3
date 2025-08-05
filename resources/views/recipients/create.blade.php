@extends('layouts.app')

@section('title', 'Tambah Penerima')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0">Tambah Data Penerima Baru</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('recipients.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="child_name" class="form-label">Nama Anak <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('child_name') is-invalid @enderror" 
                                   id="child_name" name="child_name" value="{{ old('child_name') }}" required>
                            @error('child_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="parent_name" class="form-label">Nama Orang Tua <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('parent_name') is-invalid @enderror" 
                                   id="parent_name" name="parent_name" value="{{ old('parent_name') }}" required>
                            @error('parent_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="birth_place" class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('birth_place') is-invalid @enderror" 
                                   id="birth_place" name="birth_place" value="{{ old('birth_place') }}" required>
                            @error('birth_place')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="birth_date" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('birth_date') is-invalid @enderror" 
                                   id="birth_date" name="birth_date" value="{{ old('birth_date') }}" required>
                            @error('birth_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="school_level" class="form-label">Tingkat Sekolah <span class="text-danger">*</span></label>
                            <select class="form-select @error('school_level') is-invalid @enderror" 
                                    id="school_level" name="school_level" required>
                                <option value="">Pilih Tingkat</option>
                                <option value="SD" {{ old('school_level') == 'SD' ? 'selected' : '' }}>SD</option>
                                <option value="SMP" {{ old('school_level') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                <option value="SMA" {{ old('school_level') == 'SMA' ? 'selected' : '' }}>SMA</option>
                                <option value="SMK" {{ old('school_level') == 'SMK' ? 'selected' : '' }}>SMK</option>
                            </select>
                            @error('school_level')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="school_name" class="form-label">Nama Sekolah <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('school_name') is-invalid @enderror" 
                                   id="school_name" name="school_name" value="{{ old('school_name') }}" required>
                            @error('school_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                  id="address" name="address" rows="3" required>{{ old('address') }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="class" class="form-label">Kelas <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('class') is-invalid @enderror" 
                                   id="class" name="class" value="{{ old('class') }}" placeholder="Contoh: 5A" required>
                            @error('class')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="shoe_size" class="form-label">Nomor Sepatu <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('shoe_size') is-invalid @enderror" 
                                   id="shoe_size" name="shoe_size" value="{{ old('shoe_size') }}" placeholder="Contoh: 38" required>
                            @error('shoe_size')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="shirt_size" class="form-label">Nomor Baju <span class="text-danger">*</span></label>
                            <select class="form-select @error('shirt_size') is-invalid @enderror" 
                                    id="shirt_size" name="shirt_size" required>
                                <option value="">Pilih Ukuran</option>
                                <option value="XS" {{ old('shirt_size') == 'XS' ? 'selected' : '' }}>XS</option>
                                <option value="S" {{ old('shirt_size') == 'S' ? 'selected' : '' }}>S</option>
                                <option value="M" {{ old('shirt_size') == 'M' ? 'selected' : '' }}>M</option>
                                <option value="L" {{ old('shirt_size') == 'L' ? 'selected' : '' }}>L</option>
                                <option value="XL" {{ old('shirt_size') == 'XL' ? 'selected' : '' }}>XL</option>
                                <option value="XXL" {{ old('shirt_size') == 'XXL' ? 'selected' : '' }}>XXL</option>
                            </select>
                            @error('shirt_size')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('recipients.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection