<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Anggota</title>
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
        <div class="title">Laporan Data Anggota</div>
        <div class="subtitle">Tanggal Dibuat: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</div>
    </div>

    <!-- Info -->
    <p><strong>Nama Pengguna:</strong> {{ $user->nama_anggota ?? 'Admin' }}</p>
    <p><strong>Filter Tanggal Lahir:</strong>
        {{ request('tanggal_lahir_start') ? \Carbon\Carbon::parse(request('tanggal_lahir_start'))->format('d/m/Y') : '-' }}
        s/d
        {{ request('tanggal_lahir_end') ? \Carbon\Carbon::parse(request('tanggal_lahir_end'))->format('d/m/Y') : '-' }}
    </p>
    <p><strong>Program Studi yang Difilter:</strong>
        @if (request('id_prodi'))
            {{ implode(', ', $filteredProdi) }}
        @else
            Semua Program Studi
        @endif
    </p>

    <!-- Table -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Program Studi</th>
                <th>Email</th>
                <th>Nomor HP</th>
                <th>Jenis Kelamin</th>
                <th>Tanggal Lahir</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($anggota as $index => $data)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $data->id_anggota }}</td>
                    <td>{{ $data->nama_anggota }}</td>
                    <td>{{ $data->nama_prodi }}</td>
                    <td>{{ $data->email }}</td>
                    <td>{{ $data->no_hp }}</td>
                    <td>{{ $data->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    <td>{{ \Carbon\Carbon::parse($data->tanggal_lahir)->format('d/m/Y') }}</td>
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
