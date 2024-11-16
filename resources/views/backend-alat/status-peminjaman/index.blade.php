@extends('layouts.user_type.auth')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Status Peminjaman</h5>
                    <!-- Filter Status -->
                    <form action="{{ route('status-peminjaman.index') }}" method="GET" class="d-flex align-items-center">
                        <select name="filter_status" id="filter_status" class="form-select me-2" style="width: 200px;"
                            onchange="this.form.submit()">
                            <option value="">Semua Status</option>
                            <option value="menunggu persetujuan"
                                {{ request('filter_status') == 'menunggu persetujuan' ? 'selected' : '' }}>
                                Menunggu Persetujuan</option>
                            <option value="dipinjam" {{ request('filter_status') == 'dipinjam' ? 'selected' : '' }}>
                                Dipinjam</option>
                            <option value="dikembalikan" {{ request('filter_status') == 'dikembalikan' ? 'selected' : '' }}>
                                Dikembalikan</option>
                            <option value="ditolak" {{ request('filter_status') == 'ditolak' ? 'selected' : '' }}>
                                Ditolak</option>
                        </select>
                    </form>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                        Nomor
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Nama Peminjam
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Status
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Tanggal Pinjam
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Tanggal Kembali
                                    </th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($statusPeminjaman as $index => $detail)
                                    <tr>
                                        <td class="text-center">
                                            <span class="text-xs font-weight-bold">{{ $index }}</span>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $detail['nama_peminjam'] }}</p>
                                        </td>
                                        <td>
                                            @php
                                                $statusClass = '';
                                                switch ($detail['status_peminjaman']) {
                                                    case 'menunggu persetujuan':
                                                        $statusClass = 'bg-secondary text-white'; // Abu-abu
                                                        break;
                                                    case 'dipinjam':
                                                        $statusClass = 'bg-warning text-dark'; // Kuning
                                                        break;
                                                    case 'dikembalikan':
                                                        $statusClass = 'bg-success text-white'; // Hijau
                                                        break;
                                                    case 'ditolak':
                                                        $statusClass = 'bg-danger text-white'; // Merah
                                                        break;
                                                    default:
                                                        $statusClass = 'bg-light text-dark'; // Default (Putih)
                                                }
                                            @endphp
                                            <span class="badge {{ $statusClass }}">
                                                {{ strtoupper($detail['status_peminjaman']) }}
                                            </span>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $detail['tanggal_pinjam'] }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $detail['tanggal_kembali'] }}</p>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('status-peminjaman.show', $detail['id_grup_peminjaman']) }}"
                                                class="btn btn-primary btn-sm">Details</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success mt-2 mx-4">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger mt-2 mx-4">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection
