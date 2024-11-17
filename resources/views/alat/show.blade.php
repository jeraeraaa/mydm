@extends('layouts.user_type.auth')

@section('content')
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h5 class="mb-0">Detail Alat</h5>
                <p class="text-sm">Informasi detail alat dan riwayat peminjamannya.</p>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Bagian Gambar -->
                    <div class="col-md-6 d-flex justify-content-center">
                        <img src="{{ $alat->foto ? url('storage/' . $alat->foto) : asset('assets/img/defaultbarang.jpg') }}"
                            alt="Foto Alat" class="img-fluid shadow border-radius-xl"
                            style="max-height: 300px; object-fit: cover;">
                    </div>

                    <!-- Informasi Alat -->
                    <div class="col-md-6">
                        <h6 class="text-uppercase text-secondary text-xs font-weight-bold">Informasi Alat</h6>
                        <p class="text-sm"><strong>Nama Alat:</strong> {{ $alat->nama_alat }}</p>
                        <p class="text-sm"><strong>Deskripsi:</strong> {{ $alat->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                        <p class="text-sm"><strong>Jumlah Tersedia:</strong> {{ $alat->jumlah_tersedia }}</p>
                        <p class="text-sm"><strong>Status:</strong>
                            @if ($alat->status_alat == 'A')
                                Ada
                            @elseif($alat->status_alat == 'P')
                                Sedang Dipinjam
                            @else
                                Rusak
                            @endif
                        </p>
                        <p class="text-sm"><strong>Divisi BPH:</strong>
                            {{ $alat->bph->nama_divisi_bph ?? 'Tidak ada divisi' }}</p>
                    </div>
                </div>

                <!-- Riwayat Peminjaman -->
                <div class="mt-4">
                    <h6 class="text-uppercase text-secondary text-xs font-weight-bold">Riwayat Peminjaman</h6>
                    @if ($alat->detailPeminjaman->isEmpty())
                        <p class="text-sm text-muted">Belum ada riwayat peminjaman untuk alat ini.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center text-uppercase text-secondary text-xs font-weight-bold">
                                            Peminjam
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xs font-weight-bold">
                                            Tanggal Pinjam
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xs font-weight-bold">
                                            Tanggal Kembali
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xs font-weight-bold">
                                            Kondisi Dipinjam
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xs font-weight-bold">
                                            Kondisi Dikembalikan
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($alat->detailPeminjaman as $peminjaman)
                                        <tr>
                                            <td class="text-center text-sm">
                                                {{ $peminjaman->nama_peminjam }}
                                            </td>
                                            <td class="text-center text-sm">
                                                {{ $peminjaman->tanggal_pinjam ? \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d/m/Y') : '-' }}
                                            </td>
                                            <td class="text-center text-sm">
                                                {{ $peminjaman->tanggal_kembali ? \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d/m/Y') : '-' }}
                                            </td>
                                            <td class="text-center text-sm">
                                                {{ $peminjaman->kondisi_alat_dipinjam ?? '-' }}
                                            </td>
                                            <td class="text-center text-sm">
                                                {{ $peminjaman->kondisi_setelah_dikembalikan ?? 'Belum Dikembalikan' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
