<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        /* CSS Khusus DomPDF */
        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 12px;
            color: #333;
        }
        /* Kop Surat */
        .header {
            text-align: center;
            border-bottom: 2px solid #6f42c1;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            color: #6f42c1;
            text-transform: uppercase;
        }
        .header p {
            margin: 2px 0;
            font-size: 10px;
            color: #666;
        }
        /* Info Laporan */
        .report-info {
            margin-bottom: 20px;
        }
        /* Tabel Data */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background-color: #6f42c1;
            color: white;
            padding: 10px;
            border: 1px solid #ddd;
        }
        td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: center;
        }
        .text-left { text-align: left; }
        tr:nth-child(even) { background-color: #f9f4ff; }
        
        /* Tanda Tangan */
        .signature-wrapper {
            margin-top: 50px;
            float: right;
            width: 200px;
            text-align: center;
        }
        .signature-space {
            height: 60px;
        }
    </style>
</head>
<body>

    {{-- 1. Bagian Kop --}}
    <div class="header">
        <h1>Laporan Peminjaman Alat</h1>
        <p>Sistem Informasi Sarana & Prasarana Digital</p>
        <p>JL. Dramaga No. 123, Indonesia | Tahun 2026</p>
    </div>

    {{-- 2. Bagian Detail --}}
    <div class="report-info">
        <strong>Perihal:</strong> {{ $title }} <br>
        <strong>Tanggal Cetak:</strong> {{ $date }}
    </div>

    {{-- 3. Bagian Tabel --}}
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Peminjam</th>
                <th>Alat</th>
                <th>Jumlah</th>
                <th>Tgl Pinjam</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peminjamans as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td class="text-left">{{ $item->user->name }}</td>
                <td class="text-left">{{ $item->alat->nama_alat }}</td>
                <td>{{ $item->jumlah_pinjam }}</td>
                {{-- Menggunakan format Carbon karena sudah di-cast di Model --}}
                <td>{{ $item->tanggal_pinjam->format('d/m/Y') }}</td>
                <td style="font-weight: bold; color: {{ $item->status == 'dikembalikan' ? 'green' : 'red' }}">
                    {{ strtoupper($item->status) }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- 4. Bagian Tanda Tangan --}}
    <div class="signature-wrapper">
        <p>Dicetak pada: {{ date('d M Y') }}</p>
        <p>Mengetahui, Admin</p>
        <div class="signature-space"></div>
        <hr>
        <strong>{{ auth()->user()->name }}</strong>
    </div>

</body>
</html>