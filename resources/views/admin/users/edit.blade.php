@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4" style="color: #6f42c1; font-weight: bold;">Edit Data User</h1>
    <p style="color: #d63384;">Perbarui informasi akun pengguna di bawah ini.</p>

    <div class="card mb-4" style="border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border-radius: 15px; max-width: 600px;">
        <div class="card-body p-4">
            {{-- Form Update User --}}
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" id="formEditUser">
                @csrf
                @method('PUT') 

                <div class="mb-3">
                    <label class="fw-bold mb-1" style="color: #6f42c1;">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="mb-3">
                    <label class="fw-bold mb-1" style="color: #6f42c1;">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="mb-3">
                    <label class="fw-bold mb-1" style="color: #6f42c1;">Role (Level)</label>
                    <select name="role" class="form-select" required>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="petugas" {{ $user->role == 'petugas' ? 'selected' : '' }}>Petugas</option>
                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Peminjam</option>
                    </select>
                </div>

                <hr>
                <div class="alert alert-light border-0 mb-3" style="background-color: #f8f0fc; color: #6f42c1; font-size: 0.9rem;">
                    <i class="fas fa-info-circle me-1"></i> Biarkan <strong>Password</strong> kosong jika tidak ingin diubah.
                </div>

                <div class="mb-3">
                    <label class="fw-bold mb-1" style="color: #6f42c1;">Password Baru (Opsional)</label>
                    <input type="password" name="password" class="form-control" placeholder="Isi hanya jika ingin ganti password">
                </div>

                <div class="mt-4 d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-light px-4 rounded-pill">Batal</a>
                    <button type="button" onclick="konfirmasiUpdate()" class="btn px-4 text-white rounded-pill" style="background-color: #6f42c1;">
                        <i class="fas fa-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- SweetAlert2 untuk Konfirmasi --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function konfirmasiUpdate() {
        Swal.fire({
            title: 'Konfirmasi Edit',
            text: "Simpan perubahan data user ini?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#6f42c1',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Update',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('formEditUser').submit();
            }
        })
    }
</script>
@endsection