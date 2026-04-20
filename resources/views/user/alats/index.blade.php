@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <div class="mb-4 mt-4">
        <h1 style="color: #6f42c1; font-weight: 800;">Katalog Alat</h1>
        <p style="color: #d63384; font-weight: 500;">Pilih alat yang ingin kamu pinjam untuk kegiatan praktik.</p>
    </div>

    <div class="card mb-4 shadow-sm" style="border-radius: 15px; border: none; overflow: hidden;">
        <div class="card-header py-3" style="background-color: #6f42c1; color: white;">
            <i class="fas fa-boxes me-1"></i>
            <span class="fw-bold">Daftar Alat Tersedia</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4">Nama Alat</th>
                            <th class="text-center">Stok</th>
                            <th class="text-center px-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alats as $alat)
                        <tr>
                            <td class="px-4">
                                <div class="fw-bold text-dark">{{ $alat->nama_alat }}</div>
                            </td>
                            <td class="text-center">
                                <span class="badge rounded-pill {{ $alat->jumlah > 0 ? 'bg-success' : 'bg-danger' }}">
                                    {{ $alat->jumlah }} Tersedia
                                </span>
                            </td>
                            <td class="text-center px-4">
                                @if($alat->jumlah > 0)
                                    {{-- Form Hidden: Value jumlah_pinjam akan diisi via JavaScript --}}
                                    <form id="pinjam-form-{{ $alat->id }}" action="{{ route('user.pinjam.store') }}" method="POST" style="display: none;">
                                        @csrf
                                        <input type="hidden" name="alat_id" value="{{ $alat->id }}">
                                        <input type="hidden" name="jumlah_pinjam" id="input-jumlah-{{ $alat->id }}">
                                    </form>

                                    {{-- Tombol memicu SweetAlert dengan parameter: ID, Nama, dan Stok Maksimal --}}
                                    <button type="button" 
                                            class="btn btn-sm text-white px-3 shadow-sm" 
                                            onclick="confirmPinjam({{ $alat->id }}, '{{ $alat->nama_alat }}', {{ $alat->jumlah }})"
                                            style="background-color: #d63384; border-radius: 20px; font-weight: 600;">
                                        <i class="fas fa-plus me-1"></i> Pinjam
                                    </button>
                                @else
                                    <button class="btn btn-sm btn-secondary disabled" style="border-radius: 20px;">Stok Habis</button>
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

{{-- Library SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmPinjam(id, namaAlat, stokMaksimal) {
        // Tahap 1: Input Jumlah
        Swal.fire({
            title: 'Tentukan Jumlah',
            text: `Berapa banyak ${namaAlat} yang ingin dipinjam? (Maks: ${stokMaksimal})`,
            input: 'number',
            inputAttributes: {
                min: 1,
                max: stokMaksimal,
                step: 1
            },
            inputValue: 1,
            showCancelButton: true,
            confirmButtonColor: '#6f42c1',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Lanjutkan',
            cancelButtonText: 'Batal',
            inputValidator: (value) => {
                if (!value || value < 1) {
                    return 'Jumlah minimal adalah 1!';
                }
                if (value > stokMaksimal) {
                    return `Stok tidak mencukupi! Maksimal tersedia: ${stokMaksimal}`;
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const jumlahPilihan = result.value;

                // Tahap 2: Konfirmasi Final
                Swal.fire({
                    title: 'Konfirmasi Peminjaman',
                    text: `Kamu akan meminjam ${namaAlat} sebanyak ${jumlahPilihan} unit. Lanjutkan?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#6f42c1',
                    confirmButtonText: 'Ya, Pinjam!',
                    cancelButtonText: 'Cek Lagi',
                    reverseButtons: true
                }).then((finalResult) => {
                    if (finalResult.isConfirmed) {
                        // Masukkan angka ke form hidden
                        document.getElementById('input-jumlah-' + id).value = jumlahPilihan;

                        // Tampilkan pesan sukses sebentar
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Berhasil, tunggu persetujuan admin terlebih dahulu.',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 2000
                        });

                        // Submit form ke server setelah 2 detik
                        setTimeout(() => {
                            document.getElementById('pinjam-form-' + id).submit();
                        }, 2000);
                    }
                });
            }
        });
    }
</script>

{{-- Notifikasi dari Controller jika ada --}}
@if(session('status_sukses'))
<script>
    Swal.fire({
        title: 'Terkirim!',
        text: "{{ session('status_sukses') }}",
        icon: 'success',
        confirmButtonColor: '#6f42c1'
    });
</script>
@endif

@endsection