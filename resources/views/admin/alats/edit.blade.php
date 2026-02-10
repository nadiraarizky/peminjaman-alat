<h1>Edit Alat</h1>

<!-- Tampilkan error jika ada -->
@if ($errors->any())
    <div style="background-color:#f8d7da; padding:10px; margin-bottom:15px; border-radius:4px; color:#721c24;">
        <strong>Terjadi kesalahan:</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('alats.update', $alat->id) }}" method="POST" style="max-width:400px;">
    @csrf
    @method('PUT')

    <label>Nama Alat:</label><br>
    <input type="text" name="nama_alat" value="{{ old('nama_alat', $alat->nama_alat) }}" required style="width:100%; padding:6px; margin-bottom:10px;"><br>

    <label>Kode Alat:</label><br>
    <input type="text" name="kode_alat" value="{{ old('kode_alat', $alat->kode_alat) }}" required style="width:100%; padding:6px; margin-bottom:10px;"><br>

    <label>Kondisi:</label><br>
    <input type="text" name="kondisi" value="{{ old('kondisi', $alat->kondisi) }}" style="width:100%; padding:6px; margin-bottom:10px;"><br>

    <label>Jumlah:</label><br>
    <input type="number" name="jumlah" value="{{ old('jumlah', $alat->jumlah) }}" required style="width:100%; padding:6px; margin-bottom:10px;"><br>

    <button type="submit" style="padding:8px 12px; background-color:orange; color:white; border:none; border-radius:4px;">Update</button>
</form>

<a href="{{ route('alats.index') }}" style="display:block; margin-top:10px;">Kembali ke Daftar Alat</a>
