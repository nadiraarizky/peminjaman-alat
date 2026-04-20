@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <div class="mb-4 mt-4 d-flex justify-content-between align-items-center">
        <div>
            <h1 style="color: #6f42c1; font-weight: 800;">Persetujuan Pinjaman</h1>
            <p style="color: #d63384; font-weight: 500;">Daftar permintaan alat yang menunggu konfirmasi Anda.</p>
        </div>
        <div class="bg-white px-4 py-2 rounded shadow-sm border">
            <span class="text-muted small text-uppercase fw-bold">Total Pending:</span>
            <span class="ms-2 h4 fw-black text-purple" style="color: #6f42c1;">{{ $peminjamans->count() }}</span>
        </div>
    </div>

    {{-- Alert Error manual tetap ada untuk validasi form jika diperlukan --}}
    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 15px;">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
        </div>
    @endif

    <div class="card shadow-sm border-0" style="border-radius: 20px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background-color: #f8f0fc;">
                        <tr>
                            <th class="px-4 py-3 text-uppercase small fw-bold" style="color: #6f42c1;">Peminjam</th>
                            <th class="px-4 py-3 text-uppercase small fw-bold" style="color: #6f42c1;">Alat</th>
                            <th class="px-4 py-3 text-uppercase small fw-bold text-center" style="color: #6f42c1;">Jumlah</th>
                            <th class="px-4 py-3 text-uppercase small fw-bold text-center" style="color: #6f42c1;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($peminjamans as $item)
                            <tr>
                                <td class="px-4 py-3 align-middle">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold me-3" 
                                             style="width: 40px; height: 40px; background-color: #6f42c1;">
                                            {{ substr($item->user->name, 0, 1) }}
                                        </div>
                                        <span class="fw-bold text-dark">{{ $item->user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 align-middle fw-semibold text-secondary">
                                    {{ $item->alat->nama_alat }}
                                </td>
                                <td class="px-4 py-3 align-middle text-center fw-bold" style="color: #6f42c1;">
                                    {{ $item->jumlah_pinjam }}
                                </td>
                                <td class="px-4 py-3 align-middle text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button type="button" class="btn btn-success btn-sm px-3 rounded-pill fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalApprove{{ $item->id }}">
                                            Setujui
                                        </button>

                                        <form action="{{ route('admin.peminjamans.reject', $item->id) }}" method="POST" id="form-reject-{{ $item->id }}">
                                            @csrf @method('PATCH')
                                            <button type="button" class="btn btn-danger btn-sm px-3 rounded-pill fw-bold shadow-sm" onclick="confirmReject({{ $item->id }})">
                                                Tolak
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <div class="modal fade" id="modalApprove{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content" style="border-radius: 20px; border: none;">
                                        <form action="{{ route('admin.peminjamans.approve', $item->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <div class="modal-header border-0 pt-4 px-4">
                                                <h5 class="modal-title fw-bold" style="color: #6f42c1;">Konfirmasi Persetujuan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body px-4">
                                                <p class="text-muted small">Tentukan batas waktu pengembalian alat untuk <strong>{{ $item->user->name }}</strong>.</p>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label small fw-bold text-uppercase text-secondary">Tanggal Kembali</label>
                                                    <input type="date" name="tanggal_kembali" class="form-control shadow-sm" style="border-radius: 10px;" required min="{{ date('Y-m-d') }}">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label small fw-bold text-uppercase text-secondary">Jam Pengumpulan</label>
                                                    <input type="time" name="jam_kembali" class="form-control shadow-sm" style="border-radius: 10px;" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0 pb-4 px-4">
                                                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold shadow-sm">Setujui Sekarang</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-5 text-center text-muted">
                                    <i class="fas fa-clipboard-check d-block mb-2 fa-2x"></i>
                                    Tidak ada pengajuan baru yang menunggu.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT AREA --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Pop-up sukses dengan tombol "Oke"
        @if(session('success'))
            Swal.fire({
                title: 'Berhasil!',
                // Menghilangkan &amp; secara otomatis jika masih terbawa dari controller
                text: "{!! str_replace('&amp;', '&', session('success')) !!}",
                icon: 'success',
                confirmButtonColor: '#6f42c1',
                confirmButtonText: 'Oke',
                allowOutsideClick: false
            });
        @endif
    });

    // Fungsi tambahan untuk konfirmasi Tolak
    function confirmReject(id) {
        Swal.fire({
            title: 'Tolak Pinjaman?',
            text: "Permintaan ini akan langsung dibatalkan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Tolak!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-reject-' + id).submit();
            }
        });
    }
</script>
@endsection