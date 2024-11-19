@extends('layouts.user_type.auth')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detail Kegiatan</h5>
                    <!-- Tombol Kembali ke Daftar Absensi -->
                    <a href="{{ route('absensi.index') }}" class="btn btn-secondary btn-sm">
                        Kembali ke Daftar Absensi
                    </a>
                </div>
                <div class="card-body">
                    <!-- Detail Kegiatan -->
                    <table class="table align-items-center mb-0">
                        <tbody>
                            <tr>
                                <td class="text-sm"><strong>Nama Kegiatan:</strong></td>
                                <td class="text-sm">{{ $detail->nama_detail_kegiatan }}</td>
                            </tr>
                            <tr>
                                <td class="text-sm"><strong>Deskripsi:</strong></td>
                                <td class="text-sm">{{ $detail->deskripsi_detail ?? 'Tidak ada Deskripsi' }}</td>
                            </tr>
                            <tr>
                                <td class="text-sm"><strong>Lokasi:</strong></td>
                                <td class="text-sm">{{ $detail->lokasi }}</td>
                            </tr>
                            <tr>
                                <td class="text-sm"><strong>Tanggal Mulai:</strong></td>
                                <td class="text-sm">
                                    {{ $detail->tanggal_mulai ? \Carbon\Carbon::parse($detail->tanggal_mulai)->format('d/m/Y') : '-' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-sm"><strong>Waktu Mulai:</strong></td>
                                <td class="text-sm">
                                    {{ $detail->waktu_mulai ? \Carbon\Carbon::parse($detail->waktu_mulai)->format('H:i') : '-' }}
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Tombol untuk memunculkan modal -->
                    <div class="my-3">
                        <button class="btn bg-gradient-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#absensiModal">
                            +&nbsp; Tambah Absensi
                        </button>
                    </div>
                    <div class="my-4">
                        <h6>Scan QR Code untuk Form Absensi</h6>
                        <div>
                            {!! QrCode::size(200)->generate($qrCodeUrl) !!}
                        </div>
                    </div>
                    <!-- Modal Form Absensi -->
                    <div class="modal fade" id="absensiModal" tabindex="-1" aria-labelledby="absensiModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('absensi.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id_detail_kegiatan" value="{{ $detail->id_detail_kegiatan }}">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="absensiModalLabel">Tambah Absensi</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="id_anggota" class="form-label">ID Anggota</label>
                                            <input type="text" name="id_anggota" id="id_anggota" class="form-control"
                                                placeholder="Masukkan ID Anggota (Opsional untuk Pengunjung)">
                                        </div>
                                        <div class="mb-3">
                                            <label for="nama_pengunjung" class="form-label">Nama Pengunjung</label>
                                            <input type="text" name="nama_pengunjung" id="nama_pengunjung"
                                                class="form-control" placeholder="Isi jika Anda bukan anggota">
                                        </div>
                                        <div class="mb-3">
                                            <label for="no_hp" class="form-label">No HP</label>
                                            <input type="text" name="no_hp" id="no_hp" class="form-control"
                                                placeholder="Isi nomor HP pengunjung">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Tabel Daftar Absensi -->
                    <hr class="my-4">
                    <h6>Daftar Absensi</h6>
                    <div class="table-responsive">
                        <table class="table table-striped align-items-center mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th
                                        class="text-uppercase text-secondary text-xs font-weight-bolder text-start px-3 py-2">
                                        Nama
                                    </th>
                                    <th
                                        class="text-uppercase text-secondary text-xs font-weight-bolder text-start px-3 py-2">
                                        No HP (Pengunjung)
                                    </th>
                                    <th
                                        class="text-uppercase text-secondary text-xs font-weight-bolder text-start px-3 py-2">
                                        Waktu Masuk
                                    </th>
                                    <th
                                        class="text-uppercase text-secondary text-xs font-weight-bolder text-center px-3 py-2">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($absensi as $absen)
                                    <tr>
                                        <td class="text-sm px-3 py-2">
                                            @if ($absen->anggota)
                                                {{ $absen->anggota->nama_anggota }}
                                            @else
                                                {{ $absen->pengunjung->nama_pengunjung }}
                                            @endif
                                        </td>
                                        <td class="text-sm px-3 py-2">
                                            @if ($absen->pengunjung)
                                                {{ $absen->pengunjung->no_hp }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="text-sm px-3 py-2">
                                            {{ \Carbon\Carbon::parse($absen->waktu_masuk)->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="text-center px-3 py-2">
                                            <!-- Tombol Delete -->
                                            <form action="{{ route('absensi.destroy', $absen->id_absensi) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-muted p-0"
                                                    onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
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

    @if (session('error'))
        <div class="alert alert-danger mt-2 mx-4">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger mt-2 mx-4">
            <ul class="m-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection
