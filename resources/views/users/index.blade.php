@extends('layouts.app')
@section('title','Manajemen Pengguna')
@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Daftar Pengguna</span>
        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-user-plus me-1"></i>Tambah Pengguna
        </a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th class="ps-4">#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $i => $user)
                <tr>
                    <td class="ps-4">{{ $users->firstItem() + $i }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div style="
                                width:36px; height:36px; border-radius:50%;
                                background: {{ $user->role_id == 1 ? '#0096c7' : '#059669' }};
                                display:flex; align-items:center; justify-content:center;
                                color:white; font-weight:700; font-size:.85rem; flex-shrink:0;
                            ">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="fw-semibold">{{ $user->name }}</div>
                                @if($user->id === auth()->id())
                                    <small class="text-muted">(Anda)</small>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->role_id == 1)
                            <span class="badge" style="background:#dbeafe;color:#1e40af;padding:5px 10px;border-radius:6px">
                                <i class="fas fa-crown me-1"></i>Owner
                            </span>
                        @else
                            <span class="badge" style="background:#d1fae5;color:#065f46;padding:5px 10px;border-radius:6px">
                                <i class="fas fa-user-cog me-1"></i>Admin
                            </span>
                        @endif
                    </td>
                    <td>
                        <small class="text-muted">
                            {{ $user->created_at->format('d M Y') }}
                        </small>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('users.edit', $user) }}"
                               class="btn btn-sm btn-warning"
                               title="Edit pengguna">
                                <i class="fas fa-edit"></i>
                            </a>
                            @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('users.destroy', $user) }}"
                                  class="d-inline"
                                  onsubmit="return confirm('Hapus pengguna {{ $user->name }}? Tindakan ini tidak bisa dibatalkan.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus pengguna">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @else
                            <button class="btn btn-sm btn-secondary" disabled title="Tidak bisa hapus akun sendiri">
                                <i class="fas fa-trash"></i>
                            </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">
                        <i class="fas fa-users fa-2x mb-2 d-block opacity-25"></i>
                        Belum ada pengguna terdaftar.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
    <div class="card-footer bg-white">
        {{ $users->links() }}
    </div>
    @endif
</div>

{{-- Info total --}}
<div class="mt-3 text-muted" style="font-size:.85rem">
    <i class="fas fa-info-circle me-1"></i>
    Total {{ $users->total() }} pengguna terdaftar.
</div>

@endsection