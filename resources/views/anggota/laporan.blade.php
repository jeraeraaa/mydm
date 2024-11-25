@extends('layouts.user_type.auth')
@section('content')
    <div class="container">
        <h2 class="mb-4">Laporan Data Anggota</h2>

        <!-- Tombol Kembali -->
        <div class="mb-3">
            <a href="{{ route('anggota.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Anggota
            </a>
        </div>

        <!-- Filter Form -->
        <form action="{{ route('anggota.laporan') }}" method="GET" class="mb-4">
            <div class="row">
                <!-- Rentang Tanggal Lahir -->
                <div class="col-md-4 mb-3">
                    <label for="tanggal_lahir_start" class="form-label">Tanggal Lahir (Dari):</label>
                    <input type="date" name="tanggal_lahir_start" id="tanggal_lahir_start" class="form-control"
                        value="{{ request('tanggal_lahir_start') }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="tanggal_lahir_end" class="form-label">Tanggal Lahir (Sampai):</label>
                    <input type="date" name="tanggal_lahir_end" id="tanggal_lahir_end" class="form-control"
                        value="{{ request('tanggal_lahir_end') }}">
                </div>

                <!-- Pilihan Program Studi -->
                <div class="col-md-4 mb-3">
                    <label class="form-label d-block">Program Studi:</label>
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                        data-bs-target="#filterProgramStudiModal">
                        Pilih Program Studi
                    </button>
                </div>

                <div class="col-md-12 d-flex justify-content-start">
                    <button type="submit" class="btn btn-primary me-2">Filter</button>
                    <a href="{{ route('anggota.laporan') }}" class="btn btn-secondary me-2">Reset</a>

                    <!-- Tombol Download PDF -->
                    <a href="{{ route('anggota.download.pdf', request()->all()) }}" class="btn btn-danger me-2">
                        <i class="fas fa-file-pdf"></i> Download PDF
                    </a>

                    <!-- Tombol Download Excel -->
                    <a href="{{ route('anggota.download.excel', request()->all()) }}" class="btn btn-success me-2">
                        <i class="fas fa-file-excel"></i> Download Excel
                    </a>

                    <!-- Tombol Print -->
                    <button onclick="window.print()" class="btn btn-info">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>
            </div>

            <!-- Modal Filter Program Studi -->
            <div class="modal fade" id="filterProgramStudiModal" tabindex="-1" aria-labelledby="filterProgramStudiLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="filterProgramStudiLabel">Pilih Program Studi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-check">
                                @foreach ($programStudi as $prodi)
                                    <div>
                                        <input type="checkbox" name="id_prodi[]" id="prodi_{{ $prodi->id_prodi }}"
                                            value="{{ $prodi->id_prodi }}"
                                            {{ is_array(request('id_prodi')) && in_array($prodi->id_prodi, request('id_prodi')) ? 'checked' : '' }}>
                                        <label for="prodi_{{ $prodi->id_prodi }}">{{ $prodi->nama_prodi }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>



        <!-- Tabel Data Anggota -->
        <div class="table-responsive">
            <table class="table align-items-center mb-0">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center"
                            style="width: 50px;">No
                        </th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">NIM</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Program Studi
                        </th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Email</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nomor HP</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tanggal Lahir
                        </th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jenis Kelamin
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($anggota as $data)
                        <tr>
                            <!-- Nomor Iterasi -->
                            <td class="text-center">
                                <p class="text-xs font-weight-bold mb-0">{{ $loop->iteration }}</p>
                            </td>
                            <!-- NIM -->
                            <td>
                                <p class="text-xs font-weight-bold mb-0">{{ $data->id_anggota }}</p>
                            </td>
                            <!-- Nama -->
                            <td>
                                <p class="text-xs font-weight-bold mb-0">{{ $data->nama_anggota }}</p>
                            </td>
                            <!-- Program Studi -->
                            <td>
                                <p class="text-xs font-weight-bold mb-0">{{ $data->nama_prodi }}</p>
                            </td>
                            <!-- Email -->
                            <td>
                                <p class="text-xs font-weight-bold mb-0">{{ $data->email }}</p>
                            </td>
                            <!-- Nomor HP -->
                            <td>
                                <p class="text-xs font-weight-bold mb-0">{{ $data->no_hp }}</p>
                            </td>
                            <!-- Tanggal Lahir -->
                            <td>
                                <p class="text-xs font-weight-bold mb-0">
                                    {{ \Carbon\Carbon::parse($data->tanggal_lahir)->format('d/m/Y') }}
                                </p>
                            </td>
                            <!-- Jenis Kelamin -->
                            <td>
                                <p class="text-xs font-weight-bold mb-0">
                                    {{ $data->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </p>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-xs font-weight-bold">Data tidak ditemukan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>
@endsection
