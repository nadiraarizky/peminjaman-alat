@extends('layouts.admin')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container-fluid px-4">
    <h1 class="mt-4" style="color: #6f42c1; font-weight: bold;">Manajemen User</h1>

    @if(session('success'))
        <script>
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session("success") }}',
                icon: 'success',
                confirmButtonColor: '#6f42c1'
            });
        </script>
    @endif

    <div class="row">
        {{-- Form Tambah User --}}
        <div class="col-md-4">
            <div class="card mb-4" style="border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border-radius: 10px;">
                <div class="card-header" style="background-color: #fff; color: #d63384; font-weight: bold;">
                    Tambah User Baru
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.store') }}" method="POST" onsubmit="return konfirmasiSimpan(event)">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" style="color: #6f42c1;">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" placeholder="Nama User" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="color: #6f42c1;">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="email@contoh.com" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="color: #6f42c1;">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="color: #6f42c1;">Role (Level)</label>
                            <select name="role" class="form-select" required style="border-color: #f8f0fc;">
                                <option value="admin">Admin</option>
                                <option value="petugas">Petugas</option>
                                <option value="user">Peminjam</option>
                            </select>
                        </div>
                        <button type="submit" class="btn w-100" style="background-color: #d63384; color: white; font-weight: bold;">
                            <i class="fas fa-user-plus me-1"></i> Simpan User
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Tabel User --}}
        <div class="col-md-8">
            <div class="card mb-4" style="border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border-radius: 10px;">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead style="background-color: #6f42c1; color: white;">
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr style="vertical-align: middle;">
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if($user->role == 'admin')
                                            <span class="badge bg-danger">Admin</span>
                                        @elseif($user->role == 'petugas')
                                            <span class="badge bg-warning text-dark">Petugas</span>
                                        @else
                                            <span class="badge bg-success">Peminjam</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($user->id !== auth()->id())
                                        <div class="d-flex justify-content-center gap-2">
                                            {{-- TOMBOL EDIT (INI YANG TADI HILANG) --}}
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning text-white">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            {{-- TOMBOL HAPUS DENGAN SWEETALERT --}}
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="form-hapus">
                                                @csrf @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-danger btn-delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                        @else
                                            <span class="text-muted small">Anda</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Konfirmasi Simpan
    function konfirmasiSimpan(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Simpan User Baru?',
            text: "User akan didaftarkan ke dalam sistem",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#d63384',
            cancelButtonColor: '#6f42c1',
            confirmButtonText: 'Ya, Simpan!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                event.target.submit();
            }
        });
    }

    // Konfirmasi Hapus (SweetAlert)
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('.form-hapus');
            Swal.fire({
                title: 'Yakin mau hapus?',
                text: "Data user ini bakal ilang selamanya lho!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6f42c1',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection