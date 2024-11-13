@extends('layouts.user_type.auth')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">All Activities</h5>
                        </div>
                        <!-- Filter dan Tombol Tambah -->
                        <div class="d-flex align-items-center">
                            <!-- Form Filter Kategori -->
                            <form action="{{ route('kegiatan.index') }}" method="GET" class="me-3">
                                <select class="form-select" id="kategori_filter" name="kategori_filter"
                                    style="width: 200px;" onchange="this.form.submit()">
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($kategoriList as $kat)
                                        <option value="{{ $kat->id_kategori_kegiatan }}"
                                            {{ request('kategori_filter') == $kat->id_kategori_kegiatan ? 'selected' : '' }}>
                                            {{ $kat->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>

                            <!-- Tombol Tambah Kegiatan -->
                            <a href="#" class="btn bg-gradient-primary btn-sm mb-0" data-bs-toggle="modal"
                                data-bs-target="#createActivityModal">
                                +&nbsp; Tambah Kegiatan
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center"
                                        style="width: 120px;">Actions</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                                        style="width: 250px;">Nama Kegiatan</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Kategori</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                                        style="max-width: 300px; word-break: break-word;">Deskripsi</th>
                                    {{-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Tanggal Dibuat</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kegiatan as $item)
                                    <tr>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center align-items-center gap-2">
                                                <!-- Edit Kegiatan -->
                                                <a href="{{ route('kegiatan.edit', $item->id_kegiatan) }}"
                                                    class="btn btn-link p-0 m-0">
                                                    <i class="fas fa-edit text-secondary"></i>
                                                </a>

                                                <!-- Delete Kegiatan -->
                                                <form action="{{ route('kegiatan.destroy', $item->id_kegiatan) }}"
                                                    method="POST" class="d-inline-block d-flex align-items-center m-0 p-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link p-0 m-0"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus kegiatan ini?')">
                                                        <i class="fas fa-trash text-secondary"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->nama_kegiatan }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ optional($item->kategoriKegiatan)->nama_kategori ?? 'N/A' }}</p>
                                        </td>
                                        <td style="max-width: 300px; word-break: break-word; white-space: normal;">
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->deskripsi_kegiatan ?? '-' }}
                                            </p>
                                        </td>
                                        {{-- <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</p>
                                        </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if (session('success'))
        <div class="alert alert-success mt-2 mx-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Pesan Error setelah Tabel -->
    @if ($errors->any())
        <div class="alert alert-danger mt-2 mx-4">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Modal for Creating New Activity -->
    <div class="modal fade" id="createActivityModal" tabindex="-1" role="dialog"
        aria-labelledby="createActivityModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createActivityModalLabel">Tambah Kegiatan Baru</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form tambah kegiatan -->
                    <form action="{{ route('kegiatan.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_kegiatan" class="form-label">Nama Kegiatan</label>
                            <input type="text" class="form-control" id="nama_kegiatan" name="nama_kegiatan" required>
                        </div>
                        <div class="mb-3">
                            <label for="id_kategori_kegiatan" class="form-label">Kategori</label>
                            <select class="form-select" id="id_kategori_kegiatan" name="id_kategori_kegiatan" required>
                                <option value="">Pilih Kategori</option>
                                @foreach ($kategoriList as $kat)
                                    <option value="{{ $kat->id_kategori_kegiatan }}">{{ $kat->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi_kegiatan" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi_kegiatan" name="deskripsi_kegiatan" rows="3"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
