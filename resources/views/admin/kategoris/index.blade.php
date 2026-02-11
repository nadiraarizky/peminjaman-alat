@extends('layouts.admin')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container-fluid px-4">
    <h1 class="mt-4" style="color: #6f42c1; font-weight: bold;">Manajemen Kategori</h1>

    {{-- Notifikasi Sukses Setelah Proses --}}
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
        {{-- Form Tambah Kategori --}}
        <div class="col-md-4">
            <div class="card mb-4" style="border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border-radius: 10px;">
                <div class="card-header" style="background-color: #fff; color: #d63384; font-weight: bold;">
                    Tambah Kategori Baru
                </div>
                <div class="card-body">
                    <form id="formTambahKategori" action="{{ route('admin.kategoris.store') }}" method="POST" onsubmit="return konfirmasiSimpan(event)">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" style="color: #6f42c1;">Nama Kategori</label>
                            <input type="text" name="nama_kategori" class="form-control" placeholder="Misal: Elektronik" required>
                        </div>
                        <button type="submit" class="btn w-100" style="background-color: #d63384; color: white; border-radius: 5px; font-weight: bold;">
                            <i class="fas fa-save me-1"></i> Simpan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Tabel Data Kategori --}}
        <div class="col-md-8">
            <div class="card mb-4" style="border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border-radius: 10px;">
                <div class="card-body">
                    <table class="table table-hover">
                        <thead style="background-color: #6f42c1; color: white;">
                            <tr>
                                <th width="10%">No</th>
                                <th>Nama Kategori</th>
                                <th class="text-center" width="30%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kategoris as $key => $kat)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $kat->nama_kategori }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        {{-- Tombol Edit --}}
                                        <a href="{{ route('admin.kategoris.edit', $kat->id) }}" class="btn btn-sm btn-warning text-white">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        {{-- Tombol Hapus dengan SweetAlert --}}
                                        <form action="{{ route('admin.kategoris.destroy', $kat->id) }}" method="POST" class="form-hapus">
                                            @csrf @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger btn-delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">Belum ada data.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Script Konfirmasi SweetAlert --}}
<script>
    // Konfirmasi Simpan (Tambah)
    function konfirmasiSimpan(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Yakin ingin disimpan?',
            text: "Pastikan nama kategori sudah benar!",
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

    // Konfirmasi Hapus
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('.form-hapus');
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data yang dihapus tidak bisa dikembalikan!",
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