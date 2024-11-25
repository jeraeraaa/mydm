<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Absensi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            margin: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            max-height: 80px;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .subtitle {
            font-size: 14px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #000;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 12px;
        }

        .footer .signature {
            margin-top: 60px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <img src="file://{{ public_path('assets/img/logos/dm.png') }}" alt="Logo" />
        <div class="title">Laporan Data Absensi</div>
        <div class="subtitle">Tanggal Dibuat: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</div>
    </div>

    <!-- Info -->
    <p><strong>Nama Pengguna:</strong> {{ $user->nama_anggota ?? 'Admin' }}</p>
    <p><strong>Kegiatan:</strong> {{ $filteredKegiatan->nama_detail_kegiatan ?? 'Semua Kegiatan' }}</p>
    <p><strong>Tanggal Kegiatan:</strong>
        {{ $filteredKegiatan->tanggal_mulai ? \Carbon\Carbon::parse($filteredKegiatan->tanggal_mulai)->format('d/m/Y') : '-' }}
    </p>

    <!-- Table -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Tipe</th>
                <th>No HP</th>
                <th>Waktu Masuk</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($absensi as $index => $data)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $data->anggota ? $data->anggota->nama_anggota : $data->pengunjung->nama_pengunjung }}</td>
                    <td>{{ $data->anggota ? 'Anggota' : 'Pengunjung' }}</td>
                    <td>{{ $data->pengunjung ? $data->pengunjung->no_hp : '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($data->waktu_masuk)->format('d/m/Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        <p>Jakarta, {{ \Carbon\Carbon::now()->format('d F Y') }}</p>
        <p class="signature">({{ $user->nama_anggota ?? 'Admin' }})</p>
    </div>
</body>

</html>
