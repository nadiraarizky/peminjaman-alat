<!DOCTYPE html>
<html>
<head>
    <title>Laporan Log Aktivitas</title>
    <style>
        /* Desain khusus PDF */
        body { font-family: 'Helvetica', sans-serif; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #6f42c1; padding-bottom: 10px; }
        .header h2 { margin: 0; color: #6f42c1; text-transform: uppercase; }
        .header p { margin: 5px 0; font-size: 12px; color: #666; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #dee2e6; padding: 10px; font-size: 11px; text-align: left; }
        th { background-color: #6f42c1; color: white; text-transform: uppercase; }
        tr:nth-child(even) { background-color: #fcfaff; }
        
        .footer { margin-top: 30px; text-align: right; font-size: 12px; }
        .date-info { font-style: italic; color: #d63384; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Riwayat Aktivitas Sistem</h2>
        <p>Aplikasi Peminjaman Alat Sarpras</p>
        <p class="date-info">Dicetak pada: {{ date('d F Y, H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="15%">Waktu</th>
                <th width="15%">User</th>
                <th width="15%">Aksi</th>
                <th>Keterangan / Detail Aktivitas</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $log)
            <tr>
                <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                <td><strong>{{ $log->user->name }}</strong><br><small>{{ $log->user->role }}</small></td>
                <td>{{ $log->activity }}</td>
                <td>{{ $log->description }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Mengetahui,</p>
        <br><br><br>
        <p><strong>Admin Sistem</strong></p>
    </div>
</body>
</html>