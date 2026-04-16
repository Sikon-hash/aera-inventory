@extends('layouts.app')
@section('title','Dashboard')
@section('content')

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#0096c7,#00b4d8)">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div style="opacity:.8;font-size:.85rem">Total Jenis Barang</div>
                    <div style="font-size:2rem;font-weight:700">{{ $totalBarang }}</div>
                </div>
                <i class="fas fa-boxes" style="font-size:2rem;opacity:.5"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#059669,#10b981)">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div style="opacity:.8;font-size:.85rem">Masuk Bulan Ini</div>
                    <div style="font-size:2rem;font-weight:700">{{ $totalMasukBulanIni }}</div>
                </div>
                <i class="fas fa-arrow-down" style="font-size:2rem;opacity:.5"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#d97706,#f59e0b)">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div style="opacity:.8;font-size:.85rem">Keluar Bulan Ini</div>
                    <div style="font-size:2rem;font-weight:700">{{ $totalKeluarBulanIni }}</div>
                </div>
                <i class="fas fa-arrow-up" style="font-size:2rem;opacity:.5"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#dc2626,#ef4444)">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div style="opacity:.8;font-size:.85rem">Stok Kritis</div>
                    <div style="font-size:2rem;font-weight:700">{{ $stokKritis }}</div>
                </div>
                <i class="fas fa-exclamation-triangle" style="font-size:2rem;opacity:.5"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">Daftar Stok Barang</div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead><tr>
                        <th class="ps-4">Nama Barang</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Status</th>
                    </tr></thead>
                    <tbody>
                    @foreach($barang as $b)
                    <tr>
                        <td class="ps-4">{{ $b->nama_barang }}</td>
                        <td>{{ $b->kategori }}</td>
                        <td><strong>{{ $b->stok }}</strong> {{ $b->satuan }}</td>
                        <td>
                            @if($b->stok <= $b->stok_minimum)
                                <span class="badge badge-stok-kritis px-2 py-1">⚠ Kritis</span>
                            @else
                                <span class="badge badge-stok-aman px-2 py-1">✓ Aman</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card mb-3">
            <div class="card-header">Barang Masuk Terbaru</div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead><tr><th class="ps-3">Barang</th><th>Jml</th><th>Tgl</th></tr></thead>
                    <tbody>
                    @foreach($recentMasuk as $m)
                    <tr>
                        <td class="ps-3">{{ $m->barang->nama_barang ?? '-' }}</td>
                        <td>{{ $m->jumlah_masuk }}</td>
                        <td>{{ \Carbon\Carbon::parse($m->tanggal_masuk)->format('d/m') }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card">
            <div class="card-header">Barang Keluar Terbaru</div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead><tr><th class="ps-3">Barang</th><th>Jml</th><th>Tgl</th></tr></thead>
                    <tbody>
                    @foreach($recentKeluar as $k)
                    <tr>
                        <td class="ps-3">{{ $k->barang->nama_barang ?? '-' }}</td>
                        <td>{{ $k->jumlah_keluar }}</td>
                        <td>{{ \Carbon\Carbon::parse($k->tanggal_keluar)->format('d/m') }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection