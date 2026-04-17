@extends('layouts.app')
@section('title','Barang Keluar')
@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Data Barang Keluar</span>
        <a href="{{ route('barang-keluar.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i>Tambah Barang Keluar
        </a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th class="ps-4">#</th>
                    <th>Tanggal</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Dicatat Oleh</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $i => $item)
                <tr>
                    <td class="ps-4">{{ $data->firstItem() + $i }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_keluar)->format('d M Y') }}</td>
                    <td>
                        <span class="fw-semibold">{{ $item->barang->nama_barang ?? '-' }}</span>
                        <br>
                        <small class="text-muted">{{ $item->barang->kategori ?? '' }}</small>
                    </td>
                    <td>
                        <span class="badge" style="background:#fee2e2;color:#991b1b;padding:5px 10px;border-radius:6px">
                            {{ $item->jumlah_keluar }} {{ $item->barang->satuan ?? '' }}
                        </span>
                    </td>
                    <td>{{ $item->user->name ?? '-' }}</td>
                    <td><small class="text-muted">{{ $item->keterangan ?? '-' }}</small></td>
                    <td>
                        <form method="POST" action="{{ route('barang-keluar.destroy', $item) }}"
                              class="d-inline"
                              onsubmit="return confirm('Hapus data ini? Stok barang akan dikembalikan.')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">
                        <i class="fas fa-inbox fa-2x mb-2 d-block opacity-25"></i>
                        Belum ada data barang keluar.
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