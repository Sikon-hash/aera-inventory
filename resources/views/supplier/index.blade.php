@extends('layouts.app')
@section('title','Data Supplier')
@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Data Supplier</span>
        <!-- <a href="{{ route('supplier.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i>Tambah Supplier
        </a> -->
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th class="ps-4">#</th>
                    <th>Nama Supplier</th>
                    <th>No. Telepon</th>
                    <th>Alamat</th>
                    <th>Terdaftar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($supplier as $i => $s)
                <tr>
                    <td class="ps-4">{{ $supplier->firstItem() + $i }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div style="
                                width:36px;height:36px;border-radius:8px;flex-shrink:0;
                                background:#0096c7;display:flex;align-items:center;
                                justify-content:center;color:white;font-weight:700;font-size:.85rem;
                            ">
                                {{ strtoupper(substr($s->nama_supplier, 0, 1)) }}
                            </div>
                            <span class="fw-semibold">{{ $s->nama_supplier }}</span>
                        </div>
                    </td>
                    <td>
                        @if($s->no_telepon)
                            <a href="tel:{{ $s->no_telepon }}" class="text-decoration-none">
                                <i class="fas fa-phone me-1 text-muted"></i>{{ $s->no_telepon }}
                            </a>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        <small class="text-muted">{{ $s->alamat ?? '-' }}</small>
                    </td>
                    <td>
                        <small class="text-muted">
                            {{ $s->created_at->format('d M Y') }}
                        </small>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('supplier.edit', $supplier) }}">Edit</a>
                            <form action="{{ route('supplier.destroy', $supplier) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                 <button 
                                    <!-- type="submit" class="btn btn-danger btn-sm" --> -->
                                        <!-- onclick="return confirm('Apakah Anda yakin ingin menghapus supplier ini?')"> -->
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">
                        <i class="fas fa-truck fa-2x mb-2 d-block opacity-25"></i>
                        Belum ada data supplier.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($supplier->hasPages())
    <div class="card-footer bg-white">
        {{ $supplier->links() }}
    </div>
    @endif
</div>

@endsection