@extends('layouts.app')
@section('title','Tambah Barang Keluar')
@section('content')

<div style="max-width:600px">
    <div class="card">
        <div class="card-header d-flex align-items-center gap-2">
            <a href="{{ route('barang-keluar.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left"></i>
            </a>
            <span>Catat Barang Keluar</span>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('barang-keluar.store') }}">
                @csrf

                {{-- Pilih Barang --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Barang <span class="text-danger">*</span>
                    </label>
                    <select name="id_barang" id="id_barang"
                            class="form-select @error('id_barang') is-invalid @enderror"
                            required onchange="updateInfo(this)">
                        <option value="">-- Pilih Barang --</option>
                        @foreach($barang as $b)
                            <option value="{{ $b->id_barang }}"
                                    data-satuan="{{ $b->satuan }}"
                                    data-stok="{{ $b->stok }}"
                                    {{ old('id_barang') == $b->id_barang ? 'selected' : '' }}>
                                {{ $b->nama_barang }} — Stok: {{ $b->stok }} {{ $b->satuan }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_barang')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    {{-- Info stok tersedia --}}
                    <div id="stok-info" class="mt-2 d-none">
                        <span class="badge" style="background:#d1fae5;color:#065f46;padding:5px 10px;border-radius:6px">
                            <i class="fas fa-box me-1"></i>
                            Stok tersedia: <strong id="stok-value">0</strong>
                            <span id="satuan-value"></span>
                        </span>
                    </div>
                </div>

                <div class="row">
                    {{-- Tanggal --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Tanggal Keluar <span class="text-danger">*</span>
                        </label>
                        <input type="date" name="tanggal_keluar"
                               class="form-control @error('tanggal_keluar') is-invalid @enderror"
                               value="{{ old('tanggal_keluar', date('Y-m-d')) }}" required>
                        @error('tanggal_keluar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Jumlah --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Jumlah <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <input type="number" name="jumlah_keluar" id="jumlah_keluar"
                                   class="form-control @error('jumlah_keluar') is-invalid @enderror"
                                   value="{{ old('jumlah_keluar') }}"
                                   min="1" placeholder="0" required>
                            <span class="input-group-text" id="satuan-label">-</span>
                        </div>
                        @error('jumlah_keluar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Keterangan --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="2"
                              placeholder="Opsional...">{{ old('keterangan') }}</textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Simpan
                    </button>
                    <a href="{{ route('barang-keluar.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
function updateInfo(select) {
    const option = select.options[select.selectedIndex];
    const satuan = option.getAttribute('data-satuan') || '-';
    const stok   = option.getAttribute('data-stok') || '0';

    document.getElementById('satuan-label').textContent = satuan;
    document.getElementById('satuan-value').textContent = satuan;
    document.getElementById('stok-value').textContent   = stok;
    document.getElementById('jumlah_keluar').max        = stok;

    const infoEl = document.getElementById('stok-info');
    if (select.value) {
        infoEl.classList.remove('d-none');
    } else {
        infoEl.classList.add('d-none');
    }
}
document.addEventListener('DOMContentLoaded', function() {
    const select = document.getElementById('id_barang');
    if (select.value) updateInfo(select);
});
</script>
@endsection