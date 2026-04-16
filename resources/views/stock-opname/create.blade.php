@extends('layouts.app')
@section('title','Tambah Stock Opname')
@section('content')

<div style="max-width:600px">
    <div class="card">
        <div class="card-header d-flex align-items-center gap-2">
            <a href="{{ route('stock-opname.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left"></i>
            </a>
            <span>📋 Catat Stock Opname</span>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('stock-opname.store') }}">
                @csrf

                {{-- Pilih Barang --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Barang <span class="text-danger">*</span>
                    </label>
                    <select name="id_barang" id="id_barang"
                            class="form-select @error('id_barang') is-invalid @enderror"
                            required onchange="updateStokSistem(this)">
                        <option value="">-- Pilih Barang --</option>
                        @foreach($barang as $b)
                            <option value="{{ $b->id_barang }}"
                                    data-stok="{{ $b->stok }}"
                                    data-satuan="{{ $b->satuan }}"
                                    {{ old('id_barang') == $b->id_barang ? 'selected' : '' }}>
                                {{ $b->nama_barang }} (Stok sistem: {{ $b->stok }} {{ $b->satuan }})
                            </option>
                        @endforeach
                    </select>
                    @error('id_barang')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tanggal --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Tanggal Opname <span class="text-danger">*</span>
                    </label>
                    <input type="date" name="tanggal_opname"
                           class="form-control @error('tanggal_opname') is-invalid @enderror"
                           value="{{ old('tanggal_opname', date('Y-m-d')) }}" required>
                    @error('tanggal_opname')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    {{-- Stok Sistem (readonly) --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Stok Sistem</label>
                        <div class="input-group">
                            <input type="number" name="stok_sistem" id="stok_sistem"
                                   class="form-control"
                                   value="{{ old('stok_sistem', 0) }}"
                                   readonly style="background:#f8fafc">
                            <span class="input-group-text" id="satuan-label">-</span>
                        </div>
                        <div class="form-text">Otomatis terisi dari data sistem.</div>
                    </div>

                    {{-- Stok Fisik --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Stok Fisik <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <input type="number" name="stok_fisik" id="stok_fisik"
                                   class="form-control @error('stok_fisik') is-invalid @enderror"
                                   value="{{ old('stok_fisik') }}"
                                   min="0" placeholder="Hitung fisik di gudang"
                                   required oninput="hitungSelisih()">
                            <span class="input-group-text" id="satuan-label2">-</span>
                        </div>
                        @error('stok_fisik')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Selisih (readonly, otomatis) --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Selisih</label>
                    <div class="input-group">
                        <input type="number" name="selisih" id="selisih"
                               class="form-control"
                               value="{{ old('selisih', 0) }}"
                               readonly style="background:#f8fafc">
                        <span class="input-group-text" id="selisih-label">-</span>
                    </div>
                    <div id="selisih-info" class="form-text">
                        Selisih dihitung otomatis: Stok Fisik - Stok Sistem.
                    </div>
                </div>

                {{-- Keterangan --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="2"
                              placeholder="Contoh: ada 2 pack rusak, tidak ditemukan di gudang, dll">{{ old('keterangan') }}</textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Simpan
                    </button>
                    <a href="{{ route('stock-opname.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
function updateStokSistem(select) {
    const option  = select.options[select.selectedIndex];
    const stok    = option.getAttribute('data-stok') || 0;
    const satuan  = option.getAttribute('data-satuan') || '-';

    document.getElementById('stok_sistem').value      = stok;
    document.getElementById('satuan-label').textContent  = satuan;
    document.getElementById('satuan-label2').textContent = satuan;
    document.getElementById('selisih-label').textContent = satuan;

    hitungSelisih();
}

function hitungSelisih() {
    const sistem  = parseInt(document.getElementById('stok_sistem').value) || 0;
    const fisik   = parseInt(document.getElementById('stok_fisik').value)  || 0;
    const selisih = fisik - sistem;

    document.getElementById('selisih').value = selisih;

    const infoEl = document.getElementById('selisih-info');
    if (selisih > 0) {
        infoEl.innerHTML = '<span class="text-success">✅ Stok fisik lebih banyak dari sistem sebesar ' + selisih + '</span>';
    } else if (selisih < 0) {
        infoEl.innerHTML = '<span class="text-danger">⚠️ Stok fisik kurang dari sistem sebesar ' + Math.abs(selisih) + '</span>';
    } else {
        infoEl.innerHTML = '<span class="text-primary">✔ Stok fisik sesuai dengan sistem</span>';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const select = document.getElementById('id_barang');
    if (select.value) updateStokSistem(select);
});
</script>
@endsection