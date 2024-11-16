@extends('layouts.user_type.auth')

@section('content')
    <div class="col-12">
        <div>
            <div class="card-header pb-0">
                <h5 class="mb-0">Form Pengembalian Alat</h5>
                <p class="text-sm">Masukkan informasi kondisi alat setelah dikembalikan.</p>
            </div>
            <div class="card-body">
                <form action="{{ route('pengembalian-alat.store', ['id' => $id]) }}" method="POST">
                    @csrf
                    <!-- Daftar Barang yang Dikembalikan -->
                    <h6 class="mb-3 text-uppercase text-secondary text-xs font-weight-bold">
                        Daftar Barang yang Dikembalikan
                    </h6>
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center text-xs">No</th>
                                    <th class="text-start text-xs">Nama Alat</th>
                                    <th class="text-center text-xs">Jumlah</th>
                                    <th class="text-center text-xs">Kondisi Sebelum</th>
                                    <th class="text-center text-xs">Kondisi Setelah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($detailPeminjaman as $index => $detail)
                                    <tr>
                                        <td class="text-center text-xs">{{ $index + 1 }}</td>
                                        <td class="text-start text-xs">{{ $detail->alat->nama_alat ?? 'Tidak diketahui' }}
                                        </td>
                                        <td class="text-center text-xs">{{ $detail->jumlah_dipinjam }}</td>
                                        <td class="text-center text-xs">{{ $detail->kondisi_alat_dipinjam }}</td>
                                        <td class="text-center">
                                            <input type="text"
                                                name="kondisi_setelah_dikembalikan[{{ $detail->id_detail_peminjaman_alat }}]"
                                                class="form-control form-control-sm" placeholder="Masukkan kondisi"
                                                required>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Input Tanggal Kembali -->
                    <div class="mt-4">
                        <label for="tanggal_kembali" class="form-label text-xs">Tanggal Kembali</label>
                        <input type="date" name="tanggal_kembali" id="tanggal_kembali" class="form-control"
                            value="{{ $defaultTanggalKembali }}" required>
                    </div>

                    <!-- Input Catatan -->
                    <div class="mt-3">
                        <label for="catatan" class="form-label text-xs">Catatan</label>
                        <textarea name="catatan" id="catatan" class="form-control" rows="3" placeholder="Masukkan catatan"></textarea>
                    </div>

                    <!-- Input ID Inventaris -->
                    @if (auth()->user()->role === 'inventaris' || auth()->user()->role === 'super_user')
                        <div class="mt-3">
                            <label for="id_inventaris" class="form-label text-xs">ID Inventaris</label>
                            <input type="text" name="id_inventaris" id="id_inventaris" class="form-control"
                                value="{{ auth()->user()->role === 'inventaris' ? auth()->user()->id : '' }}"
                                {{ auth()->user()->role === 'inventaris' ? 'readonly' : '' }} required>
                        </div>
                    @endif

                    <button type="submit" class="btn btn-success mt-4">Simpan Pengembalian</button>
                </form>
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
