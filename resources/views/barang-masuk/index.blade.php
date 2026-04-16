@extends('layouts.app')
@section('title','Barang Masuk')
@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>📥 Data Barang Masuk</span>
        <a href="{{ route('barang-masuk.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i>Tambah Barang Masuk
        </a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th class="ps-4">#</th>
                    <th>Tanggal</th>
                    <th>Nama Barang</th>
                    <th>Supplier</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan</th>
                    <th>Total</th>
                    <th>Dicatat Oleh</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $i => $item)
                <tr>
                    <td class="ps-4">{{ $data->firstItem() + $i }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_masuk)->format('d M Y') }}</td>
                    <td>
                        <span class="fw-semibold">{{ $item->barang->nama_barang ?? '-' }}</span>
                        <br>
                        <small class="text-muted">{{ $item->barang->kategori ?? '' }}</small>
                    </td>
                    <td>{{ $item->supplier->nama_supplier ?? '-' }}</td>
                    <td>
                        <span class="badge" style="background:#dbeafe;color:#1e40af;padding:5px 10px;border-radius:6px">
                            {{ $item->jumlah_masuk }} {{ $item->barang->satuan ?? '' }}
                        </span>
                    </td>
                    <td>Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->harga_satuan * $item->jumlah_masuk, 0, ',', '.') }}</td>
                    <td>{{ $item->user->name ?? '-' }}</td>
                    <td>
                        <small class="text-muted">{{ $item->keterangan ?? '-' }}</small>
                    </td>
                    <td>
                        <form method="POST" action="{{ route('barang-masuk.destroy', $item) }}"
                              class="d-inline"
                              onsubmit="return confirm('Hapus data ini? Stok barang akan dikurangi kembali.')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center py-4 text-muted">
                        <i class="fas fa-inbox fa-2x mb-2 d-block opacity-25"></i>
                        Belum ada data barang masuk.
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