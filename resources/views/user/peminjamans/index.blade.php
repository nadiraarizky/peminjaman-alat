@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <div class="mb-4 mt-4">
        <h1 style="color: #6f42c1; font-weight: 800;">Pinjaman Saya</h1>
        <p style="color: #d63384; font-weight: 500;">Daftar alat yang sedang kamu pinjam atau menunggu persetujuan.</p>
    </div>

    <div class="card shadow-sm border-0" style="border-radius: 20px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background-color: #f8f0fc;">
                        <tr>
                            <th class="px-4 py-3 text-uppercase small fw-bold" style="color: #6f42c1;">Nama Alat</th>
                            <th class="px-4 py-3 text-uppercase small fw-bold text-center" style="color: #6f42c1;">Jumlah</th>
                            <th class="px-4 py-3 text-uppercase small fw-bold text-center" style="color: #6f42c1;">Tenggat & Estimasi Denda</th>
                            <th class="px-4 py-3 text-uppercase small fw-bold text-center" style="color: #6f42c1;">Status</th>
                            <th class="px-4 py-3 text-uppercase small fw-bold text-center" style="color: #6f42c1;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($peminjamans as $item)
                            <tr>
                                <td class="px-4 py-3 align-middle">
                                    <div class="fw-bold text-dark">{{ $item->alat->nama_alat }}</div>
                                    <div class="small text-muted">
                                        <i class="far fa-calendar-alt me-1"></i> 
                                        Dipinjam: {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}
                                    </div>
                                </td>
                                <td class="px-4 py-3 align-middle text-center fw-bold" style="color: #6f42c1;">
                                    {{ $item->jumlah_pinjam }}
                                </td>
                                <td class="px-4 py-3 align-middle text-center">
                                    @if($item->status == 'dipinjam' && $item->tanggal_kembali)
                                        @php
                                            $tenggat = \Carbon\Carbon::parse($item->tanggal_kembali);
                                            $sekarang = \Carbon\Carbon::now();
                                            
                                            // Cek apakah sekarang sudah melewati tenggat
                                            $isTerlambat = $sekarang->isAfter($tenggat);
                                            
                                            $estimasiDenda = 0;
                                            $teksTerlambat = '';

                                            if($isTerlambat) {
                                                // diffInHours(target, absolute = true) agar tidak negatif
                                                $totalJamTelat = $sekarang->diffInHours($tenggat, false); 
                                                // Karena isAfter true, diffInHours akan positif jika kita balik logikanya atau pakai abs()
                                                $totalJamTelat = abs($totalJamTelat);

                                                if($totalJamTelat < 24) {
                                                    $teksTerlambat = ($totalJamTelat == 0 ? 1 : floor($totalJamTelat)) . ' jam';
                                                    $estimasiDenda = 5000; 
                                                } else {
                                                    $totalHariTelat = abs($sekarang->diffInDays($tenggat));
                                                    $teksTerlambat = floor($totalHariTelat) . ' hari';
                                                    $estimasiDenda = (floor($totalHariTelat) + 1) * 5000;
                                                }
                                            }
                                        @endphp
                                        
                                        <div class="fw-bold {{ $isTerlambat ? 'text-danger' : 'text-dark' }}">
                                            <i class="fas fa-calendar-day me-1 small"></i> {{ $tenggat->format('d M Y H:i') }}
                                        </div>

                                        @if($isTerlambat)
                                            <div class="mt-1">
                                                <span class="badge bg-danger shadow-sm">
                                                    Terlambat {{ $teksTerlambat }}
                                                </span>
                                            </div>
                                            <div class="text-danger fw-bold small mt-1">
                                                Denda: Rp {{ number_format($estimasiDenda, 0, ',', '.') }}
                                            </div>
                                        @else
                                            <div class="small fw-bold text-primary mt-1">
                                                <i class="fas fa-clock me-1 small"></i> 
                                                Sisa: {{ $sekarang->diffForHumans($tenggat, true) }}
                                            </div>
                                        @endif
                                    @else
                                        <span class="text-muted small italic">
                                            @if($item->status == 'pending')
                                                Menunggu persetujuan...
                                            @else
                                                Tenggat belum ditentukan
                                            @endif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 align-middle text-center">
                                    @if($item->status == 'pending')
                                        <span class="badge bg-warning text-dark rounded-pill px-3 shadow-sm">
                                            <i class="fas fa-spinner fa-spin me-1"></i> PENDING
                                        </span>
                                    @elseif($item->status == 'dipinjam')
                                        <span class="badge bg-primary rounded-pill px-3 shadow-sm">
                                            <i class="fas fa-hand-holding me-1"></i> DIPINJAM
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 align-middle text-center">
                                    @if($item->status == 'dipinjam')
                                        {{-- PERBAIKAN: Menggunakan user.pinjam.return sesuai web.php --}}
                                        <form id="return-form-{{ $item->id }}" action="{{ route('user.pinjam.return', $item->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('PATCH')
                                        </form>

                                        <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-bold shadow-sm" 
                                            onclick="confirmReturn({{ $item->id }}, '{{ $item->alat->nama_alat }}', '{{ $estimasiDenda ?? 0 }}')">
                                            <i class="fas fa-undo me-1"></i> Kembalikan
                                        </button>
                                    @else
                                        <button class="btn btn-sm btn-light disabled rounded-pill px-3" style="font-style: italic;">
                                            Diproses...
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-5 text-center text-muted">
                                    <i class="fas fa-info-circle mb-2 fa-2x d-block"></i>
                                    Kamu tidak memiliki pinjaman aktif saat ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmReturn(id, namaAlat, denda) {
        let warningText = `Apakah kamu yakin ingin mengembalikan ${namaAlat}?`;
        let iconType = 'question';

        if (parseInt(denda) > 0) {
            let formattedDenda = new Intl.NumberFormat('id-ID', { 
                style: 'currency', 
                currency: 'IDR', 
                minimumFractionDigits: 0 
            }).format(denda);
            warningText = `Kamu terlambat mengembalikan! Estimasi denda saat ini: ${formattedDenda}. Lanjutkan pengembalian?`;
            iconType = 'warning';
        }

        Swal.fire({
            title: 'Konfirmasi Pengembalian',
            text: warningText,
            icon: iconType,
            showCancelButton: true,
            confirmButtonColor: '#6f42c1',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Kembalikan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('return-form-' + id).submit();
            }
        });
    }
</script>
@endsection