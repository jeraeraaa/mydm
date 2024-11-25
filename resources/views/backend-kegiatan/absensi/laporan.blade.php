@extends('layouts.user_type.auth')
@section('content')
    <div class="container">
        <h2 class="mb-4">Laporan Data Absensi - {{ $detailKegiatan->nama_detail_kegiatan }}</h2>

        <!-- Tombol Kembali -->
        <div class="mb-3">
            @if (isset($detailKegiatan) && $detailKegiatan->id_detail_kegiatan)
                <a href="{{ route('absensi.show', ['absensi' => $detailKegiatan->id_detail_kegiatan]) }}"
                    class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Detail Kegiatan
                </a>
            @else
                <a href="{{ route('absensi.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Absensi
                </a>
            @endif

            <!-- Tombol Download PDF -->
            <a href="{{ route('absensi.download.pdf', $detailKegiatan->id_detail_kegiatan) }}" class="btn btn-danger me-2">
                <i class="fas fa-file-pdf"></i> Download PDF
            </a>

            <!-- Tombol Download Excel -->
            <a href="{{ route('absensi.download.excel', $detailKegiatan->id_detail_kegiatan) }}"
                class="btn btn-success me-2">
                <i class="fas fa-file-excel"></i> Download Excel
            </a>

            <!-- Tombol Print -->
            <button onclick="window.print()" class="btn btn-info">
                <i class="fas fa-print"></i> Print
            </button>
        </div>

        <!-- Tabel Data Absensi -->
        <div class="table-responsive">
            <table class="table align-items-center mb-0">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                            No
                        </th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                            Nama
                        </th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                            Waktu Masuk
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($absensi as $data)
                        <tr>
                            <td class="text-center">
                                <p class="text-xs font-weight-bold mb-0">{{ $loop->iteration }}</p>
                            </td>
                            <td class="text-center">
                                <p class="text-xs font-weight-bold mb-0">
                                    {{ $data->anggota ? $data->anggota->nama_anggota : $data->pengunjung->nama_pengunjung }}
                                </p>
                            </td>
                            <td class="text-center">
                                <p class="text-xs font-weight-bold mb-0">
                                    {{ \Carbon\Carbon::parse($data->waktu_masuk)->format('d/m/Y H:i') }}
                                </p>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">
                                <p class="text-xs font-weight-bold mb-0">Data tidak ditemukan</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
@endsection
