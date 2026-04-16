@extends('layouts.app')
@section('title','Tambah Barang')
@section('content')
<div class="card" style="max-width:600px">
    <div class="card-header">Tambah Barang Baru</div>
    <div class="card-body">
        <form method="POST" action="{{ route('barang.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Barang</label>
                <input type="text" name="nama_barang" class="form-control" value="{{ old('nama_barang') }}" required>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Kategori</label>
                    <select name="kategori" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        <option value="Ayam">Ayam</option>
                        <option value="Seafood">Seafood</option>
                        <option value="Olahan">Olahan</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Satuan</label>
                    <input type="text" name="satuan" class="form-control" value="{{ old('satuan') }}" placeholder="kg / pack / pcs" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Stok Awal</label>
                    <input type="number" name="stok" class="form-control" value="{{ old('stok',0) }}" min="0" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Stok Minimum (Alert)</label>
                    <input type="number" name="stok_minimum" class="form-control" value="{{ old('stok_minimum',10) }}" min="0" required>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('barang.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection