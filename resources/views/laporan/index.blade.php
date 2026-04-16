@extends('layouts.app')
@section('title','Laporan Inventaris')
@section('content')

{{-- Filter Bulan & Tahun --}}
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('laporan.index') }}" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label fw-semibold">Bulan</label>
                <select name="bulan" class="form-select">
                    @foreach(range(1,12) as $b)
                        <option value="{{ $b }}" {{ $bulan == $b ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($b)->translatedFormat('F') }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Tahun</label>
                <select name="tahun" class="form-select">
                    @foreach(range(date('Y'), date('Y')-3) as $t)
                        <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>
                            {{ $t }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-filter me-1"></i>Tampilkan
                </button>
            </div>
            <div class="col-md-3">
                <button type="button" class="btn btn-outline-secondary w-100" onclick="window.print()">
                    <i class="fas fa-print me-1"></i>Cetak Laporan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Ringkasan --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card text-center" style="border-top:4px solid #0096c7">
            <div class="card-body">
                <div class="text-muted mb-1" style="font-size:.85rem">Total Masuk Bulan Ini</div>
                <div style="font-size:1.8rem;font-weight:700;color:#0096c7">
                    {{ $masuk->sum('jumlah_masuk') }}
                </div>
                <small class="text-muted">dari {{ $masuk->count() }} transaksi</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center" style="border-top:4px solid #dc2626">
            <div class="card-body">
                <div class="text-muted mb-1" style="font-size:.85rem">Total Keluar Bulan Ini</div>
                <div style="font-size:1.8rem;font-weight:700;color:#dc2626">
                    {{ $keluar->sum('jumlah_keluar') }}
                </div>
                <small class="text-muted">dari {{ $keluar->count() }} transaksi</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center" style="border-top:4px solid #059669">
            <div class="card-body">
                <div class="text-muted mb-1" style="font-size:.85rem">Total Nilai Pembelian</div>
                <div style="font-size:1.8rem;font-weight:700;color:#059669">
                    Rp {{ number_format($masuk->sum(fn($m) => $m->jumlah_masuk * $m->harga_satuan), 0, ',', '.') }}
                </div>
                <small class="text-muted">total pengeluaran supplier</small>
            </div>
        </div>
    </div>
</div>

{{-- Tabel Barang Masuk --}}
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>
            📥 Barang Masuk —
            <span class="text-muted fw-normal">
                {{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }} {{ $tahun }}
            </span>
        </span>
        <span class="badge bg-primary">{{ $masuk->count() }} transaksi</span>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th class="ps-4">#</th>
                    <th>Tanggal</th>
                    <th>Barang</th>
                    <th>Supplier</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($masuk as $i => $m)
                <tr>
                    <td class="ps-4">{{ $i + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($m->tanggal_masuk)->format('d M Y') }}</td>
                    <td>{{ $m->barang->nama_barang ?? '-' }}</td>
                    <td>{{ $m->supplier->nama_supplier ?? '-' }}</td>
                    <td>{{ $m->jumlah_masuk }} {{ $m->barang->satuan ?? '' }}</td>
                    <td>Rp {{ number_format($m->harga_satuan, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($m->harga_satuan * $m->jumlah_masuk, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-3 text-muted">
                        Tidak ada data barang masuk pada periode ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
            @if($masuk->count() > 0)
            <tfoot style="background:#f8fafc">
                <tr>
                    <td colspan="4" class="ps-4 fw-semibold">Total</td>
                    <td class="fw-semibold">{{ $masuk->sum('jumlah_masuk') }}</td>
                    <td></td>
                    <td class="fw-semibold">
                        Rp {{ number_format($masuk->sum(fn($m) => $m->jumlah_masuk * $m->harga_satuan), 0, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>

{{-- Tabel Barang Keluar --}}
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>
            📤 Barang Keluar —
            <span class="text-muted fw-normal">
                {{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }} {{ $tahun }}
            </span>
        </span>
        <span class="badge bg-danger">{{ $keluar->count() }} transaksi</span>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th class="ps-4">#</th>
                    <th>Tanggal</th>
                    <th>Barang</th>
                    <th>Jumlah</th>
                    <th>Dicatat Oleh</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($keluar as $i => $k)
                <tr>
                    <td class="ps-4">{{ $i + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($k->tanggal_keluar)->format('d M Y') }}</td>
                    <td>{{ $k->barang->nama_barang ?? '-' }}</td>
                    <td>{{ $k->jumlah_keluar }} {{ $k->barang->satuan ?? '' }}</td>
                    <td>{{ $k->user->name ?? '-' }}</td>
                    <td><small class="text-muted">{{ $k->keterangan ?? '-' }}</small></td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-3 text-muted">
                        Tidak ada data barang keluar pada periode ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
            @if($keluar->count() > 0)
            <tfoot style="background:#f8fafc">
                <tr>
                    <td colspan="3" class="ps-4 fw-semibold">Total</td>
                    <td class="fw-semibold">{{ $keluar->sum('jumlah_keluar') }}</td>
                    <td colspan="2"></td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>

{{-- Tabel Rekap Stok Semua Barang --}}
<div class="card">
    <div class="card-header">
        📦 Rekap Stok Barang Saat Ini
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th class="ps-4">#</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Min. Stok</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($stokBarang as $i => $b)
                <tr>
                    <td class="ps-4">{{ $i + 1 }}</td>
                    <td class="fw-semibold">{{ $b->nama_barang }}</td>
                    <td>{{ $b->kategori }}</td>
                    <td>{{ $b->stok }} {{ $b->satuan }}</td>
                    <td>{{ $b->stok_minimum }}</td>
                    <td>
                        @if($b->stok <= $b->stok_minimum)
                            <span class="badge" style="background:#fee2e2;color:#991b1b;padding:5px 10px;border-radius:6px">
                                ⚠ Kritis
                            </span>
                        @else
                            <span class="badge" style="background:#d1fae5;color:#065f46;padding:5px 10px;border-radius:6px">
                                ✓ Aman
                            </span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('scripts')
<script>
// Agar nama bulan dalam bahasa Indonesia
window.addEventListener('DOMContentLoaded', function() {
    @php
        \Carbon\Carbon::setLocale('id');
    @endphp
});
</script>
@endsection