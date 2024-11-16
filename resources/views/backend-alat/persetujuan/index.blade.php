@extends('layouts.user_type.auth')

@section('content')
    <div class="col-12">
        <div class="card mb-4 mx-4">
            <div class="card-header pb-0">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <h5 class="mb-0">Daftar Persetujuan Peminjaman</h5>
                        <p class="text-sm">Berikut adalah daftar peminjaman yang menunggu persetujuan</p>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-items-center mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                    No</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama
                                    Peminjam</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                    Jumlah Item</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                    Tanggal Pinjam</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                    Status</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($persetujuan as $index => $grup)
                                <tr>
                                    <td class="text-center">
                                        <div class="text-sm font-weight-bold mb-0">
                                            {{ $index + 1 }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <img src="{{ asset('assets/img/default-user.png') }}"
                                                    class="avatar avatar-sm me-3" alt="user">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $grup->nama_peminjam ?? 'Tidak Diketahui' }}
                                                </h6>
                                                <p class="text-xs text-secondary mb-0">
                                                    {{ $grup->identitas_peminjam ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-sm font-weight-bold">{{ $grup->jumlah_item }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-sm font-weight-bold">{{ $grup->tanggal_pinjam }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-sm bg-gradient-warning">Menunggu Persetujuan</span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('persetujuan.show', $grup->id_persetujuan_ketum) }}"
                                            class="btn btn-outline-primary btn-sm">Detail</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <div class="alert alert-info">Tidak ada peminjaman yang menunggu persetujuan.</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Pesan Sukses -->
    @if (session('success'))
        <div class="alert alert-success mt-2 mx-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Pesan Error -->
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
