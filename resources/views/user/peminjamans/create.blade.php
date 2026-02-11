@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4" style="color: #6f42c1;">Form Peminjaman</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active" style="color: #d63384;">Isi jumlah alat yang ingin kamu pinjam</li>
    </ol>
    
    <div class="card mb-4 shadow-sm" style="max-width: 500px; border: none; border-radius: 15px;">
        <div class="card-header" style="background-color: #6f42c1; color: white; border-radius: 15px 15px 0 0;">
            <i class="fas fa-edit me-1"></i> Pinjam: {{ $alat->nama_alat }}
        </div>
        <div class="card-body">
            <form id="formPinjam" action="{{ route('user.pinjam.store') }}" method="POST">
                @csrf
                {{-- ID Alat yang disembunyikan --}}
                <input type="hidden" name="alat_id" value="{{ $alat->id }}">
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Jumlah (Stok: {{ $alat->jumlah }})</label>
                    <input type="number" name="jumlah" class="form-control" max="{{ $alat->jumlah }}" min="1" value="1" required>
                </div>

                <button type="button" onclick="konfirmasiSimpan()" class="btn text-white w-100" style="background-color: #d63384; border-radius: 8px;">
                    Konfirmasi Pinjaman
                </button>
                
                {{-- Tombol Kembali yang memicu pop-up --}}
                <a href="javascript:void(0)" onclick="konfirmasiBatal()" class="btn btn-light w-100 mt-2" style="border-radius: 8px;">
                    Kembali
                </a>
            </form>
        </div>
    </div>
</div>

{{-- Load SweetAlert2 Library --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Fungsi untuk konfirmasi saat mau meminjam (tombol pink)
function konfirmasiSimpan() {
    Swal.fire({
        title: 'Yakin ingin menyimpannya?',
        text: "Pastikan jumlah alat yang kamu pinjam sudah benar!",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#6f42c1', 
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Simpan!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('formPinjam').submit();
        }
    })
}

// Fungsi untuk konfirmasi saat mau membatalkan/kembali (tombol putih)
function konfirmasiBatal() {
    Swal.fire({
        title: 'Yakin ingin kembali?',
        text: "Perubahan yang kamu buat tidak akan disimpan.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33', // Merah untuk peringatan keluar
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Keluar!',
        cancelButtonText: 'Lanjut Pinjam'
    }).then((result) => {
        if (result.isConfirmed) {
            // Pindah halaman ke katalog alat
            window.location.href = "{{ route('user.alats.index') }}";
        }
    })
}
</script>
@endsection