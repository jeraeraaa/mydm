@extends('layouts.user_type.auth')

@section('content')
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h5 class="mb-0">Detail Peminjaman Alat</h5>
                <p class="text-sm">Informasi detail peminjaman alat dan statusnya.</p>
            </div>
            <div class="card-body">
                <!-- Informasi Peminjam -->
                <h6 class="text-uppercase text-secondary text-xs font-weight-bold">Informasi Peminjam</h6>
                <div class="row">
                    <div class="col-md-6">
                        <p class="text-sm"><strong>Nama Peminjam:</strong> {{ $namaPeminjam }}</p>
                        <p class="text-sm"><strong>NIM:</strong> {{ $nim ?? '-' }}</p>
                        <p class="text-sm"><strong>Fakultas/Jurusan:</strong>
                            {{ $fakultas ?? 'Tidak Berlaku' }} / {{ $jurusan ?? 'Tidak Berlaku' }}
                        </p>
                        <p class="text-sm"><strong>Organisasi:</strong> {{ $organisasi }}</p>
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
                                        <span class="text-xs">{{ $detail->alat->nama_alat ?? 'Tidak diketahui' }}</span>
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="text-xs">{{ $detail->jumlah_dipinjam }}</span>
                                    </td>
                                    <td class="text-center align-middle">
                                        <span
                                            class="text-xs">{{ $detail->kondisi_alat_dipinjam ?? 'Tidak diketahui' }}</span>
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="text-xs">{{ $detail->tanggal_pinjam }}</span>
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="text-xs">{{ $detail->tanggal_kembali ?? 'Belum Dikembalikan' }}</span>
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
                @if ($actionButton)
                    <div class="mt-4 d-flex justify-content-end">
                        <a href="{{ $actionButton['route'] }}" class="{{ $actionButton['class'] }}">
                            {{ $actionButton['label'] }}
                        </a>
                    </div>
                @endif

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
