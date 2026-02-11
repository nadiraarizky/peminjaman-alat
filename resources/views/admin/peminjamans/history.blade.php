@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    {{-- Header & Tombol Cetak --}}
    <div class="d-flex justify-content-between align-items-center mb-4 mt-4">
        <div>
            <h1 style="color: #6f42c1; font-weight: 800;">Riwayat & Laporan</h1>
            <p style="color: #d63384; font-weight: 500;">Pantau semua aktivitas peminjaman yang telah selesai atau diproses.</p>
        </div>
        {{-- Tombol PDF Baru --}}
        <a href="{{ route('admin.peminjamans.exportPDF') }}" class="btn btn-primary shadow-sm rounded-pill px-4 fw-bold" style="background-color: #6f42c1; border: none;">
            <i class="fas fa-file-pdf me-2"></i> Cetak Laporan PDF
        </a>
    </div>

    {{-- Ringkasan Status --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3 mb-2" style="border-radius: 15px; border-left: 5px solid #0d6efd !important;">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <div class="small fw-bold text-uppercase text-muted">Disetujui</div>
                        <div class="h4 fw-black mb-0">{{ $peminjamans->where('status', 'dipinjam')->count() }}</div>
                    </div>
                    <i class="fas fa-check-circle fa-2x text-primary opacity-25"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3 mb-2" style="border-radius: 15px; border-left: 5px solid #198754 !important;">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <div class="small fw-bold text-uppercase text-muted">Dikembalikan</div>
                        <div class="h4 fw-black mb-0">{{ $peminjamans->where('status', 'dikembalikan')->count() }}</div>
                    </div>
                    <i class="fas fa-undo fa-2x text-success opacity-25"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3 mb-2" style="border-radius: 15px; border-left: 5px solid #dc3545 !important;">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <div class="small fw-bold text-uppercase text-muted">Ditolak</div>
                        <div class="h4 fw-black mb-0">{{ $peminjamans->where('status', 'ditolak')->count() }}</div>
                    </div>
                    <i class="fas fa-times-circle fa-2x text-danger opacity-25"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0" style="border-radius: 20px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background-color: #f8f0fc;">
                        <tr>
                            <th class="px-4 py-3 text-uppercase small fw-bold" style="color: #6f42c1;">Peminjam</th>
                            <th class="px-4 py-3 text-uppercase small fw-bold" style="color: #6f42c1;">Alat</th>
                            <th class="px-4 py-3 text-uppercase small fw-bold text-center" style="color: #6f42c1;">Jumlah</th>
                            <th class="px-4 py-3 text-uppercase small fw-bold text-center" style="color: #6f42c1;">Status Akhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($peminjamans as $item)
                            <tr>
                                <td class="px-4 py-3 align-middle">
                                    <div class="fw-bold text-dark">{{ $item->user->name }}</div>
                                    <div class="small text-muted">{{ $item->user->email }}</div>
                                </td>
                                <td class="px-4 py-3 align-middle text-secondary">{{ $item->alat->nama_alat }}</td>
                                <td class="px-4 py-3 align-middle text-center fw-bold">{{ $item->jumlah_pinjam }}</td>
                                <td class="px-4 py-3 align-middle text-center">
                                    @if($item->status == 'dipinjam')
                                        <span class="badge bg-primary rounded-pill px-3">DISETUJUI</span>
                                    @elseif($item->status == 'dikembalikan')
                                        <span class="badge bg-success rounded-pill px-3">DIKEMBALIKAN</span>
                                    @else
                                        <span class="badge bg-danger rounded-pill px-3 text-uppercase">{{ $item->status }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-5 text-center text-muted">Belum ada aktivitas peminjaman.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection