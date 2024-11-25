<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Alat</title>
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
        <div class="title">Laporan Data Alat</div>
        <div class="subtitle">Tanggal Dibuat: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</div>
    </div>

    <!-- Info -->
    <p><strong>Nama Pengguna:</strong> {{ $user->nama_anggota ?? 'Admin' }}</p>
    <p><strong>Filter Divisi BPH:</strong>
        {{ request('id_bph') ? $filteredBph : 'Semua Divisi' }}
    </p>

    <!-- Table -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID Alat</th>
                <th>Nama Alat</th>
                <th>Deskripsi</th>
                <th>Jumlah Tersedia</th>
                <th>Status</th>
                <th>Divisi BPH</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($alat as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->id_alat }}</td>
                    <td>{{ $item->nama_alat }}</td>
                    <td>{{ $item->deskripsi }}</td>
                    <td>{{ $item->jumlah_tersedia }}</td>
                    <td>
                        {{ $item->status_alat == 'A' ? 'Ada' : ($item->status_alat == 'P' ? 'Pinjam' : 'Rusak') }}
                    </td>
                    <td>{{ $item->nama_divisi_bph }}</td>
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
