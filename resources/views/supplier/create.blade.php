@extends('layouts.app')
@section('title','Tambah Supplier')
@section('content')

<div style="max-width:560px">
    <div class="card">
        <div class="card-header d-flex align-items-center gap-2">
            <a href="{{ route('supplier.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left"></i>
            </a>
            <span>➕ Tambah Supplier</span>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('supplier.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Nama Supplier <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="nama_supplier"
                           class="form-control @error('nama_supplier') is-invalid @enderror"
                           value="{{ old('nama_supplier') }}"
                           placeholder="Nama perusahaan / toko supplier"
                           required>
                    @error('nama_supplier')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">No. Telepon</label>
                    <input type="text" name="no_telepon"
                           class="form-control @error('no_telepon') is-invalid @enderror"
                           value="{{ old('no_telepon') }}"
                           placeholder="08xxxxxxxxxx">
                    @error('no_telepon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Alamat</label>
                    <textarea name="alamat" rows="3"
                              class="form-control @error('alamat') is-invalid @enderror"
                              placeholder="Alamat lengkap supplier">{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Simpan
                    </button>
                    <a href="{{ route('supplier.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection