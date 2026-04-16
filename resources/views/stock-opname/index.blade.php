@extends('layouts.app')
@section('title','Stock Opname')
@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>📋 Data Stock Opname</span>
        <a href="{{ route('stock-opname.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i>Tambah Stock Opname
        </a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th class="ps-4">#</th>
                    <th>Tanggal</th>
                    <th>Nama Barang</th>
                    <th>Stok Sistem</th>
                    <th>Stok Fisik</th>
                    <th>Selisih</th>
                    <th>Dicatat Oleh</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $i => $item)
                <tr>
                    <td class="ps-4">{{ $data->firstItem() + $i }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_opname)->format('d M Y') }}</td>
                    <td>
                        <span class="fw-semibold">{{ $item->barang->nama_barang ?? '-' }}</span>
                    </td>
                    <td>{{ $item->stok_sistem }} {{ $item->barang->satuan ?? '' }}</td>
                    <td>{{ $item->stok_fisik }} {{ $item->barang->satuan ?? '' }}</td>
                    <td>
                        @if($item->selisih > 0)
                            <span class="badge" style="background:#d1fae5;color:#065f46;padding:5px 10px;border-radius:6px">
                                +{{ $item->selisih }}
                            </span>
                        @elseif($item->selisih < 0)
                            <span class="badge" style="background:#fee2e2;color:#991b1b;padding:5px 10px;border-radius:6px">
                                {{ $item->selisih }}
                            </span>
                        @else
                            <span class="badge" style="background:#e0e7ff;color:#3730a3;padding:5px 10px;border-radius:6px">
                                Sesuai
                            </span>
                        @endif
                    </td>
                    <td>{{ $item->user->name ?? '-' }}</td>
                    <td><small class="text-muted">{{ $item->keterangan ?? '-' }}</small></td>
                    <td>
                        <form method="POST" action="{{ route('stock-opname.destroy', $item) }}"
                              class="d-inline"
                              onsubmit="return confirm('Hapus data stock opname ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-4 text-muted">
                        <i class="fas fa-clipboard fa-2x mb-2 d-block opacity-25"></i>
                        Belum ada data stock opname.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($data->hasPages())
    <div class="card-footer bg-white">
        {{ $data->links() }}
    </div>
    @endif
</div>

@endsection