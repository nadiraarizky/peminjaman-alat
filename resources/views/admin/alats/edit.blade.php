@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4" style="color: #6f42c1; font-weight: bold;">Edit Data Alat</h1>
    <p style="color: #d63384;">Silakan perbarui informasi inventaris di bawah ini.</p>

    <div class="card mb-4" style="border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border-radius: 15px;">
        <div class="card-body p-4">
            {{-- Form dengan ID untuk ditangkap JavaScript --}}
            <form action="{{ route('admin.alats.update', $alat->id) }}" method="POST" id="formEditAlat">
                @csrf
                @method('PUT') 

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold mb-1" style="color: #6f42c1;">Kode Alat</label>
                        <input type="text" name="kode_alat" class="form-control" value="{{ old('kode_alat', $alat->kode_alat) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold mb-1" style="color: #6f42c1;">Nama Alat</label>
                        <input type="text" name="nama_alat" class="form-control" value="{{ old('nama_alat', $alat->nama_alat) }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold mb-1" style="color: #6f42c1;">Kategori</label>
                        <select name="kategori_id" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ $alat->kategori_id == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="fw-bold mb-1" style="color: #6f42c1;">Kondisi</label>
                        <select name="kondisi" class="form-select" required>
                            <option value="baru" {{ $alat->kondisi == 'baru' ? 'selected' : '' }}>Baru</option>
                            <option value="bekas" {{ $alat->kondisi == 'bekas' ? 'selected' : '' }}>Bekas</option>
                            <option value="rusak" {{ $alat->kondisi == 'rusak' ? 'selected' : '' }}>Rusak</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="fw-bold mb-1" style="color: #6f42c1;">Jumlah Unit</label>
                        <input type="number" name="jumlah" class="form-control" value="{{ old('jumlah', $alat->jumlah) }}" required>
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.alats.index') }}" class="btn btn-light px-4 rounded-pill">Batal</a>
                    {{-- Tombol memicu fungsi JavaScript konfirmasiSimpan --}}
                    <button type="button" onclick="konfirmasiSimpan()" class="btn px-4 text-white rounded-pill" style="background-color: #6f42c1;">
                        <i class="fas fa-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Memanggil SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function konfirmasiSimpan() {
        Swal.fire({
            title: 'Konfirmasi',
            text: "Yakin ingin menyimpan perubahannya?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#6f42c1', // Warna ungu serasi
            cancelButtonColor: '#d33',     // Warna merah untuk batal
            confirmButtonText: 'Ya, Simpan',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form secara manual jika user klik 'Ya, Simpan'
                document.getElementById('formEditAlat').submit();
            }
        })
    }
</script>
@endsection