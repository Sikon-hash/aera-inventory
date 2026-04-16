@extends('layouts.app')
@section('title','Tambah Barang Masuk')
@section('content')

<div style="max-width:600px">
    <div class="card">
        <div class="card-header d-flex align-items-center gap-2">
            <a href="{{ route('barang-masuk.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left"></i>
            </a>
            <span>📥 Catat Barang Masuk</span>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('barang-masuk.store') }}">
                @csrf

                {{-- Pilih Barang --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Barang <span class="text-danger">*</span>
                    </label>
                    <select name="id_barang" id="id_barang"
                            class="form-select @error('id_barang') is-invalid @enderror"
                            required onchange="updateSatuan(this)">
                        <option value="">-- Pilih Barang --</option>
                        @foreach($barang as $b)
                            <option value="{{ $b->id_barang }}"
                                    data-satuan="{{ $b->satuan }}"
                                    data-stok="{{ $b->stok }}"
                                    {{ old('id_barang') == $b->id_barang ? 'selected' : '' }}>
                                {{ $b->nama_barang }} (Stok: {{ $b->stok }} {{ $b->satuan }})
                            </option>
                        @endforeach
                    </select>
                    @error('id_barang')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Pilih Supplier --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Supplier <span class="text-danger">*</span>
                    </label>
                    <select name="id_supplier"
                            class="form-select @error('id_supplier') is-invalid @enderror"
                            required>
                        <option value="">-- Pilih Supplier --</option>
                        @foreach($supplier as $s)
                            <option value="{{ $s->id_supplier }}"
                                {{ old('id_supplier') == $s->id_supplier ? 'selected' : '' }}>
                                {{ $s->nama_supplier }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_supplier')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    {{-- Tanggal --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Tanggal Masuk <span class="text-danger">*</span>
                        </label>
                        <input type="date" name="tanggal_masuk"
                               class="form-control @error('tanggal_masuk') is-invalid @enderror"
                               value="{{ old('tanggal_masuk', date('Y-m-d')) }}" required>
                        @error('tanggal_masuk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Jumlah --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Jumlah <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <input type="number" name="jumlah_masuk"
                                   class="form-control @error('jumlah_masuk') is-invalid @enderror"
                                   value="{{ old('jumlah_masuk') }}"
                                   min="1" placeholder="0" required>
                            <span class="input-group-text" id="satuan-label">-</span>
                        </div>
                        @error('jumlah_masuk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Harga Satuan --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Harga Satuan (Rp)</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="harga_satuan"
                               class="form-control @error('harga_satuan') is-invalid @enderror"
                               value="{{ old('harga_satuan', 0) }}"
                               min="0" placeholder="0">
                    </div>
                    @error('harga_satuan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
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
                    <a href="{{ route('barang-masuk.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
function updateSatuan(select) {
    const option = select.options[select.selectedIndex];
    const satuan = option.getAttribute('data-satuan') || '-';
    document.getElementById('satuan-label').textContent = satuan;
}
// Jalankan saat halaman load jika ada old value
document.addEventListener('DOMContentLoaded', function() {
    const select = document.getElementById('id_barang');
    if (select.value) updateSatuan(select);
});
</script>
@endsection