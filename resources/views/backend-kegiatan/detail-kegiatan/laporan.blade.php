@extends('layouts.user_type.auth')

@section('content')
    <div class="container">
        <h4>Laporan Detail Kegiatan</h4>
        <form method="GET" action="{{ route('detail-kegiatan.laporan') }}" class="mb-3">
            <div class="row">
                <!-- Tombol Kembali -->
                <div>
                    <a href="{{ route('detail-kegiatan.index') }}" class="btn btn-secondary mb-3">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                    </a>
                </div>

                <!-- Filter Tanggal -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" class="form-control"
                            value="{{ request('tanggal_mulai') }}">
                    </div>
                    <div class="col-md-6">
                        <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" class="form-control"
                            value="{{ request('tanggal_selesai') }}">
                    </div>
                </div>

                <!-- Tombol Filter dan Download -->
                <div class="row">
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100" style="height: 40px;">Filter</button>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('detail-kegiatan.download.pdf', request()->all()) }}" class="btn btn-danger w-100"
                            style="height: 40px;">
                            <i class="fas fa-file-pdf"></i> PDF
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('detail-kegiatan.download.excel', request()->all()) }}"
                            class="btn btn-success w-100" style="height: 40px;">
                            <i class="fas fa-file-excel"></i> Excel
                        </a>
                    </div>
                    <div class="col-md-3">
                        <button onclick="window.print()" class="btn btn-info w-100" style="height: 40px;">
                            <i class="fas fa-print"></i> Print
                        </button>
                    </div>
                </div>
            </div>


        </form>

        <table class="table align-items-center mb-0">
            <thead>
                <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">No</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Detail
                        Kegiatan</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tanggal</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Waktu</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Lokasi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($detailKegiatan as $item)
                    <tr>
                        <td class="text-center">
                            <p class="text-xs font-weight-bold mb-0">{{ $loop->iteration }}</p>
                        </td>
                        <td>
                            <p class="text-xs font-weight-bold mb-0">{{ $item->nama_detail_kegiatan }}</p>
                        </td>
                        <td>
                            <p class="text-xs font-weight-bold mb-0">
                                {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d/m/Y') }} -
                                {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d/m/Y') }}
                            </p>
                        </td>
                        <td>
                            <p class="text-xs font-weight-bold mb-0">
                                {{ \Carbon\Carbon::parse($item->waktu_mulai)->format('H:i') }} -
                                {{ \Carbon\Carbon::parse($item->waktu_selesai)->format('H:i') }}
                            </p>
                        </td>
                        <td>
                            <p class="text-xs font-weight-bold mb-0">{{ $item->lokasi }}</p>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
