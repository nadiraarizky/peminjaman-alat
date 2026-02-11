@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4" style="color: #6f42c1; font-weight: bold;">Edit Kategori</h1>
    
    <div class="card mb-4" style="border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border-radius: 10px; max-width: 500px;">
        <div class="card-body">
            <form action="{{ route('admin.kategoris.update', $kategori->id) }}" method="POST" id="formEditKategori">
                @csrf
                @method('PUT') {{-- Wajib ada untuk update data --}}
                
                <div class="mb-3">
                    <label class="form-label fw-bold" style="color: #6f42c1;">Nama Kategori</label>
                    <input type="text" name="nama_kategori" class="form-control" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.kategoris.index') }}" class="btn btn-light">Batal</a>
                    <button type="button" onclick="konfirmasiSimpan()" class="btn text-white" style="background-color: #6f42c1;">
                        <i class="fas fa-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function konfirmasiSimpan() {
        Swal.fire({
            title: 'Konfirmasi',
            text: "Yakin ingin menyimpan perubahannya?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#6f42c1',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Simpan',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('formEditKategori').submit();
            }
        })
    }
</script>
@endsection