@extends('layouts.app')
@section('title','Data Barang')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Data Barang</span>
        <a href="{{ route('barang.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i>Tambah Barang
        </a>
    </div>
    <div class="card-body">
        <form method="GET" class="mb-3 d-flex gap-2">
            <input type="text" name="search" value="{{ $search }}" class="form-control" style="max-width:300px" placeholder="Cari nama barang...">
            <button class="btn btn-outline-secondary"><i class="fas fa-search"></i></button>
        </form>
        <table class="table table-hover">
            <thead><tr>
                <th>#</th><th>Nama Barang</th><th>Kategori</th><th>Satuan</th>
                <th>Stok</th><th>Min. Stok</th><th>Status</th><th>Aksi</th>
            </tr></thead>
            <tbody>
            @foreach($barang as $i => $b)
            <tr>
                <td>{{ $barang->firstItem() + $i }}</td>
                <td>{{ $b->nama_barang }}</td>
                <td>{{ $b->kategori }}</td>
                <td>{{ $b->satuan }}</td>
                <td><strong>{{ $b->stok }}</strong></td>
                <td>{{ $b->stok_minimum }}</td>
                <td>
                    @if($b->stok <= $b->stok_minimum)
                        <span class="badge badge-stok-kritis">⚠ Kritis</span>
                    @else
                        <span class="badge badge-stok-aman">✓ Aman</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('barang.edit', $b) }}" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form method="POST" action="{{ route('barang.destroy', $b) }}" class="d-inline"
                          onsubmit="return confirm('Hapus barang ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        {{ $barang->links() }}
    </div>
</div>
@endsection