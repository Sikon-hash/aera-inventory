@extends('layouts.app')
@section('title','Edit Pengguna')
@section('content')

<div style="max-width:560px">

    {{-- Info Card Pengguna --}}
    <div class="card mb-3" style="border-left: 4px solid #0096c7;">
        <div class="card-body py-3 d-flex align-items-center gap-3">
            <div style="
                width:48px; height:48px; border-radius:50%; flex-shrink:0;
                background: {{ $user->role_id == 1 ? '#0096c7' : '#059669' }};
                display:flex; align-items:center; justify-content:center;
                color:white; font-weight:700; font-size:1.2rem;
            ">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <div class="fw-semibold">{{ $user->name }}</div>
                <small class="text-muted">{{ $user->email }}</small>
                &nbsp;
                <span class="badge" style="
                    background: {{ $user->role_id == 1 ? '#dbeafe' : '#d1fae5' }};
                    color: {{ $user->role_id == 1 ? '#1e40af' : '#065f46' }};
                    padding: 3px 8px; border-radius:5px; font-size:.75rem;
                ">
                    {{ $user->role->nama_role }}
                </span>
            </div>
        </div>
    </div>

    {{-- Form Edit Data --}}
    <div class="card mb-3">
        <div class="card-header d-flex align-items-center gap-2">
            <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left"></i>
            </a>
            <span>Edit Data Pengguna</span>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('users.update', $user) }}">
                @csrf
                @method('PUT')

                {{-- Nama --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Nama Lengkap <span class="text-danger">*</span>
                    </label>
                    <input
                        type="text"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $user->name) }}"
                        required
                    >
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Email <span class="text-danger">*</span>
                    </label>
                    <input
                        type="email"
                        name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', $user->email) }}"
                        required
                    >
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Role --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        Role / Hak Akses <span class="text-danger">*</span>
                    </label>
                    <select name="role_id" class="form-select @error('role_id') is-invalid @enderror" required
                        {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                        @foreach($roles as $role)
                            <option value="{{ $role->id_role }}"
                                {{ old('role_id', $user->role_id) == $role->id_role ? 'selected' : '' }}>
                                {{ $role->nama_role }}
                            </option>
                        @endforeach
                    </select>
                    {{-- Jika disabled, kirim tetap via hidden input --}}
                    @if($user->id === auth()->id())
                        <input type="hidden" name="role_id" value="{{ $user->role_id }}">
                        <div class="form-text text-warning">
                            <i class="fas fa-lock me-1"></i>
                            Anda tidak bisa mengubah role akun sendiri.
                        </div>
                    @endif
                    @error('role_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Simpan Perubahan
                    </button>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Form Ganti Password --}}
    <div class="card">
        <div class="card-header">
            Reset Password Pengguna
        </div>
        <div class="card-body">
            <p class="text-muted" style="font-size:.875rem">
                Kosongkan jika tidak ingin mengganti password pengguna ini.
            </p>
            <form method="POST" action="{{ route('users.update', $user) }}">
                @csrf
                @method('PUT')
                {{-- Kirim ulang data yang wajib agar validasi tidak gagal --}}
                <input type="hidden" name="name"    value="{{ $user->name }}">
                <input type="hidden" name="email"   value="{{ $user->email }}">
                <input type="hidden" name="role_id" value="{{ $user->role_id }}">

                <div class="mb-3">
                    <label class="form-label fw-semibold">Password Baru</label>
                    <div class="input-group">
                        <input
                            type="password"
                            name="password"
                            id="new_password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Minimal 8 karakter"
                        >
                        <button type="button" class="btn btn-outline-secondary"
                                onclick="togglePassword('new_password', this)">
                            <i class="fas fa-eye"></i>
                        </button>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Konfirmasi Password Baru</label>
                    <div class="input-group">
                        <input
                            type="password"
                            name="password_confirmation"
                            id="confirm_password"
                            class="form-control"
                            placeholder="Ulangi password baru"
                        >
                        <button type="button" class="btn btn-outline-secondary"
                                onclick="togglePassword('confirm_password', this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-key me-1"></i>Reset Password
                </button>
            </form>
        </div>
    </div>

</div>

@endsection

@section('scripts')
<script>
function togglePassword(fieldId, btn) {
    const field = document.getElementById(fieldId);
    const icon  = btn.querySelector('i');
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
</script>
@endsection