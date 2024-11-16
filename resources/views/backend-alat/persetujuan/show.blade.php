@extends('layouts.user_type.auth')

@section('content')
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h5 class="mb-0">Detail Persetujuan Peminjaman</h5>
                <p class="text-sm">Informasi detail peminjaman yang menunggu persetujuan.</p>
            </div>
            <div class="card-body">
                <!-- Informasi Peminjam -->
                <h6 class="text-uppercase text-secondary text-xs font-weight-bold">Informasi Peminjam</h6>
                <div class="row">
                    <div class="col-md-6">
                        <p class="text-sm"><strong>Nama Peminjam:</strong> {{ $namaPeminjam ?? 'Tidak Diketahui' }}</p>
                        <p class="text-sm"><strong>Identitas Peminjam:</strong> {{ $identitasPeminjam ?? '-' }}</p>
                        <p class="text-sm"><strong>Fakultas/Jurusan:</strong>
                            {{ $fakultas ?? 'Tidak Berlaku' }} / {{ $jurusan ?? 'Tidak Berlaku' }}
                        </p>
                        <p class="text-sm"><strong>Organisasi:</strong> {{ $organisasi ?? 'Tidak Diketahui' }}</p>
                    </div>
                </div>

                <!-- Daftar Barang yang Dipinjam -->
                <h6 class="mt-4 text-uppercase text-secondary text-xs font-weight-bold">Daftar Barang yang Dipinjam</h6>
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center">
                                    No
                                </th>
                                <th
                                    class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-start align-left">
                                    Nama Alat
                                </th>
                                <th
                                    class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center align-middle">
                                    Jumlah
                                </th>
                                <th
                                    class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center align-middle">
                                    Kondisi
                                </th>
                                <th
                                    class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center align-middle">
                                    Tanggal Pinjam
                                </th>
                                <th
                                    class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center align-middle">
                                    Tanggal Kembali
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($detailPeminjaman as $index => $detail)
                                <tr>
                                    <td class="text-center align-middle">
                                        <span class="text-xs font-weight-bold">{{ $index + 1 }}</span>
                                    </td>
                                    <td class="text-start align-left">
                                        <span class="text-xs">{{ $detail['nama_alat'] }}</span>
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="text-xs">{{ $detail['jumlah_dipinjam'] }}</span>
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="text-xs">{{ $detail['kondisi_alat_dipinjam'] }}</span>
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="text-xs">{{ $detail['tanggal_pinjam'] }}</span>
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="text-xs">{{ $detail['tanggal_kembali'] }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <div class="alert alert-info text-sm">Tidak ada barang yang dipinjam.</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

                <!-- Tombol Aksi -->
                <div class="mt-4 d-flex justify-content-between align-items-center">
                    <!-- Form untuk Menolak -->
                    <div class="d-flex align-items-center">
                        <form action="{{ route('persetujuan.reject', $persetujuanKetum->id_persetujuan_ketum) }}"
                            method="POST" class="d-flex align-items-center">
                            @csrf
                            <input type="text" name="alasan" class="form-control form-control-sm me-2"
                                placeholder="Masukkan alasan penolakan" required style="width: 300px; height: 40px;" />
                            <button type="submit" class="btn btn-danger btn-sm" style="height: 40px;">Tolak</button>
                        </form>
                    </div>


                    <!-- Form untuk Menyetujui -->
                    <div class="d-flex align-items-center justify-content-end">
                        <form action="{{ route('persetujuan.approve', $persetujuanKetum->id_persetujuan_ketum) }}"
                            method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm" style="height: 38px;">Setujui</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    
    <!-- Pesan Sukses -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif


    <!-- Pesan Error -->
    @if ($errors->any())
        <div class="alert alert-danger mt-2">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection
