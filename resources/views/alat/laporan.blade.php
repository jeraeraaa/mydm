@extends('layouts.user_type.auth')

@section('content')
    <div class="container">
        <h4>Laporan Alat</h4>
        <form method="GET" action="{{ route('alat.laporan') }}" class="mb-3">
            <div class="row">
                <!-- Tombol Kembali -->
                <div>
                    <a href="{{ route('alat.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                    </a>
                </div>
                <div class="col-md-12 d-flex justify-content-start">
                    <div class="col-md-4 me-2">
                        <select name="id_bph" class="form-select" onchange="this.form.submit()">
                            <option value="">Semua Divisi</option>
                            @foreach ($bphList as $bph)
                                <option value="{{ $bph->id_bph }}"
                                    {{ request('id_bph') == $bph->id_bph ? 'selected' : '' }}>
                                    {{ $bph->nama_divisi_bph }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tombol Download PDF -->
                    <a href="{{ route('alat.download.pdf', request()->all()) }}" class="btn btn-danger me-2">
                        <i class="fas fa-file-pdf"></i> Download PDF
                    </a>

                    <!-- Tombol Download Excel -->
                    <a href="{{ route('alat.download.excel', request()->all()) }}" class="btn btn-success me-2">
                        <i class="fas fa-file-excel"></i> Download Excel
                    </a>

                    <!-- Tombol Print -->
                    <button onclick="window.print()" class="btn btn-info">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>
            </div>
        </form>

        <table class="table align-items-center mb-0">
            <thead>
                <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">No</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">ID Alat</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Alat</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Deskripsi</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jumlah Tersedia
                    </th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Divisi BPH</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($alat as $item)
                    <tr>
                        <!-- Nomor Iterasi -->
                        <td class="text-center">
                            <p class="text-xs font-weight-bold mb-0">{{ $loop->iteration }}</p>
                        </td>
                        <td>
                            <p class="text-xs font-weight-bold mb-0">{{ $item->id_alat }}</p>
                        </td>
                        <td>
                            <p class="text-xs font-weight-bold mb-0">{{ $item->nama_alat }}</p>
                        </td>
                        <td>
                            <p class="text-xs font-weight-bold mb-0">{{ $item->deskripsi }}</p>
                        </td>
                        <td>
                            <p class="text-xs font-weight-bold mb-0">{{ $item->jumlah_tersedia }}</p>
                        </td>
                        <td>
                            <p class="text-xs font-weight-bold mb-0">
                                {{ $item->status_alat == 'A' ? 'Ada' : ($item->status_alat == 'P' ? 'Pinjam' : 'Rusak') }}
                            </p>
                        </td>
                        <td>
                            <p class="text-xs font-weight-bold mb-0">{{ $item->nama_divisi_bph }}</p>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
@endsection
