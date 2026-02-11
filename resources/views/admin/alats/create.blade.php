@extends('layouts.admin')

@section('content')
{{-- Library SweetAlert2 untuk popup tengah --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container-fluid px-4">
    {{-- Judul warna Ungu --}}
    <h1 class="mt-4" style="color: #6f42c1; font-weight: bold;">Tambah Alat Baru</h1>
    
    <div class="card mb-4" style="border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border-radius: 10px;">
        {{-- Header Form warna Pink Soft --}}
        <div class="card-header" style="background-color: #fff; color: #d63384; font-weight: bold; border-bottom: 1px solid #f8f0fc;">
            <i class="fas fa-edit me-1"></i> Form Input Inventaris
        </div>
        <div class="card-body">
            <form action="{{ route('admin.alats.store') }}" method="POST" id="formAlat">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label" style="color: #6f42c1; font-weight: 500;">Kode Alat</label>
                    <input type="text" name="kode_alat" class="form-control" style="border-color: #f8f0fc;" value="{{ old('kode_alat') }}" placeholder="Masukkan kode alat..." required>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="color: #6f42c1; font-weight: 500;">Nama Alat</label>
                    <input type="text" name="nama_alat" class="form-control" style="border-color: #f8f0fc;" value="{{ old('nama_alat') }}" placeholder="Masukkan nama alat..." required>
                </div>

                {{-- --- BAGIAN DROPDOWN KATEGORI (TAMBAHAN) --- --}}
                <div class="mb-3">
                    <label class="form-label" style="color: #6f42c1; font-weight: 500;">Kategori Alat</label>
                    <select name="kategori_id" class="form-select" style="border-color: #f8f0fc;" required>
                        <option value="" disabled selected>-- Pilih Kategori --</option>
                        @foreach($kategoris as $kat)
                            <option value="{{ $kat->id }}" {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    <small class="text-muted">Pilih kategori yang sesuai untuk alat ini.</small>
                </div>
                {{-- ------------------------------------------- --}}

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label" style="color: #6f42c1; font-weight: 500;">Kondisi</label>
                        <select name="kondisi" class="form-select" style="border-color: #f8f0fc;" required>
                            <option value="baru" {{ old('kondisi') == 'baru' ? 'selected' : '' }}>Baru</option>
                            <option value="bekas" {{ old('kondisi') == 'bekas' ? 'selected' : '' }}>Bekas</option>
                            <option value="rusak" {{ old('kondisi') == 'rusak' ? 'selected' : '' }}>Rusak</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" style="color: #6f42c1; font-weight: 500;">Jumlah</label>
                        <input type="number" name="jumlah" class="form-control" style="border-color: #f8f0fc;" value="{{ old('jumlah') }}" placeholder="0" required>
                    </div>
                </div>

                <hr style="color: #f8f0fc;">

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.alats.index') }}" class="btn btn-secondary" style="border-radius: 5px;">Batal</a>
                    {{-- Tombol Simpan warna Pink --}}
                    <button type="button" class="btn" style="background-color: #d63384; color: white; border-radius: 5px;" onclick="confirmSimpan()">
                        <i class="fas fa-save me-1"></i> Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function confirmSimpan() {
        Swal.fire({
            title: 'Yakin ingin disimpan?',
            text: "Pastikan data sudah benar ya!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#d63384', // Warna Pink
            cancelButtonColor: '#6f42c1',  // Warna Ungu
            confirmButtonText: 'Yes, simpan!',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('formAlat').submit();
            }
        })
    }
</script>
@endsection