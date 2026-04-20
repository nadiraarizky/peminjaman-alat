@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    {{-- Header --}}
    <div class="mb-4 mt-4">
        <h1 style="color: #6f42c1; font-weight: 800;">Riwayat & Laporan</h1>
        <p style="color: #d63384; font-weight: 500;">Pantau aktivitas peminjaman dan cetak laporan berdasarkan periode.</p>
    </div>

    {{-- Form Filter Periode --}}
    <div class="card shadow-sm border-0 mb-4" style="border-radius: 20px;">
        <div class="card-body p-4">
            <form action="{{ route('admin.peminjamans.exportPDF') }}" method="GET" target="_blank">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="small fw-bold text-uppercase text-muted mb-2 d-block">Pilih Periode Laporan</label>
                        <select name="periode" id="periodeSelect" class="form-select border-0 bg-light" style="border-radius: 12px; padding: 12px;">
                            <option value="semua">Semua Riwayat</option>
                            <option value="harian">Harian (Hari Ini)</option>
                            <option value="mingguan">Mingguan (7 Hari Terakhir)</option>
                            <option value="bulanan">Bulanan (Bulan Ini)</option>
                            <option value="custom">Custom Tanggal...</option>
                        </select>
                    </div>

                    {{-- Input Tanggal Custom --}}
                    <div class="col-md-5" id="customDateRange" style="display: none;">
                        <div class="row g-2">
                            <div class="col-6">
                                <label class="small fw-bold text-muted mb-2 d-block">Dari Tanggal</label>
                                <input type="date" name="tgl_mulai" id="tgl_mulai" class="form-control border-0 bg-light" style="border-radius: 12px; padding: 11px;">
                            </div>
                            <div class="col-6">
                                <label class="small fw-bold text-muted mb-2 d-block">Sampai Tanggal</label>
                                <input type="date" name="tgl_selesai" id="tgl_selesai" class="form-control border-0 bg-light" style="border-radius: 12px; padding: 11px;">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100 shadow-sm fw-bold" style="background-color: #6f42c1; border: none; border-radius: 12px; padding: 12px;">
                            <i class="fas fa-file-pdf me-2"></i> Cetak PDF
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Ringkasan Status --}}
    <div class="row mb-4 text-center text-md-start">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3 mb-2" style="border-radius: 15px; border-left: 5px solid #0d6efd !important;">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <div class="small fw-bold text-uppercase text-muted text-start">Disetujui</div>
                        <div class="h4 fw-black mb-0 text-start">{{ $peminjamans->where('status', 'dipinjam')->count() }}</div>
                    </div>
                    <i class="fas fa-check-circle fa-2x text-primary opacity-25"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3 mb-2" style="border-radius: 15px; border-left: 5px solid #198754 !important;">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <div class="small fw-bold text-uppercase text-muted text-start">Dikembalikan</div>
                        <div class="h4 fw-black mb-0 text-start">{{ $peminjamans->where('status', 'dikembalikan')->count() }}</div>
                    </div>
                    <i class="fas fa-undo fa-2x text-success opacity-25"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3 mb-2" style="border-radius: 15px; border-left: 5px solid #dc3545 !important;">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <div class="small fw-bold text-uppercase text-muted text-start">Ditolak</div>
                        <div class="h4 fw-black mb-0 text-start">{{ $peminjamans->where('status', 'ditolak')->count() }}</div>
                    </div>
                    <i class="fas fa-times-circle fa-2x text-danger opacity-25"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="card shadow-sm border-0" style="border-radius: 20px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background-color: #f8f0fc;">
                        <tr>
                            <th class="px-4 py-3 text-uppercase small fw-bold" style="color: #6f42c1;">Peminjam</th>
                            <th class="px-4 py-3 text-uppercase small fw-bold" style="color: #6f42c1;">Alat</th>
                            <th class="px-4 py-3 text-uppercase small fw-bold text-center" style="color: #6f42c1;">Jumlah</th>
                            <th class="px-4 py-3 text-uppercase small fw-bold text-center" style="color: #6f42c1;">Denda</th>
                            <th class="px-4 py-3 text-uppercase small fw-bold text-center" style="color: #6f42c1;">Status Akhir</th>
                            <th class="px-4 py-3 text-uppercase small fw-bold text-center" style="color: #6f42c1;">Aksi</th>
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
                                    @if($item->denda > 0)
                                        <span class="text-danger fw-bold">Rp {{ number_format($item->denda, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>

                                <td class="px-4 py-3 align-middle text-center">
                                    @if($item->status == 'dipinjam')
                                        <span class="badge bg-primary rounded-pill px-3">DISETUJUI</span>
                                    @elseif($item->status == 'dikembalikan')
                                        <span class="badge bg-success rounded-pill px-3">DIKEMBALIKAN</span>
                                    @else
                                        <span class="badge bg-danger rounded-pill px-3 text-uppercase">{{ $item->status }}</span>
                                    @endif
                                </td>

                                <td class="px-4 py-3 align-middle text-center">
                                    @if($item->denda > 0)
                                        {{-- Form Tersembunyi untuk SweetAlert --}}
                                        <form action="{{ route('admin.peminjamans.payDenda', $item->id) }}" method="POST" id="form-lunas-{{ $item->id }}" style="display:none;">
                                            @csrf
                                        </form>
                                        
                                        <button type="button" class="btn btn-sm btn-success shadow-sm btn-lunas" data-id="{{ $item->id }}" style="border-radius: 8px;">
                                            <i class="fas fa-money-bill-wave me-1"></i> Lunas
                                        </button>
                                    @else
                                        <span class="text-muted small">Selesai</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-5 text-center text-muted">
                                    <i class="fas fa-folder-open fa-2x d-block mb-2 opacity-25"></i>
                                    Belum ada aktivitas peminjaman.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Toggle Custom Tanggal
        const select = document.getElementById('periodeSelect');
        const customDiv = document.getElementById('customDateRange');
        const tglMulai = document.getElementById('tgl_mulai');
        const tglSelesai = document.getElementById('tgl_selesai');

        if(select) {
            select.addEventListener('change', function() {
                if (this.value === 'custom') {
                    customDiv.style.display = 'block';
                    tglMulai.required = true;
                    tglSelesai.required = true;
                } else {
                    customDiv.style.display = 'none';
                    tglMulai.required = false;
                    tglSelesai.required = false;
                }
            });
        }

        // 2. Konfirmasi SweetAlert untuk Tombol Lunas
        const lunasButtons = document.querySelectorAll('.btn-lunas');
        lunasButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                
                Swal.fire({
                    title: 'Konfirmasi Pembayaran',
                    text: "Apakah anda yakin user ini sudah membayar denda secara tunai?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#6f42c1',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Sudah Lunas',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    borderRadius: '15px'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('form-lunas-' + id).submit();
                    }
                });
            });
        });
    });
</script>
@endpush
@endsection