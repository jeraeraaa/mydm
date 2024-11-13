@extends('layouts.user_type.auth')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">All Materials</h5>
                        </div>
                        <!-- Filter dan Tombol Tambah -->
                        <div class="d-flex align-items-center">
                            <!-- Form Filter Pembicara -->
                            <form action="{{ route('materi.index') }}" method="GET" class="me-3">
                                <select class="form-select" id="pembicara_filter" name="pembicara_filter"
                                    style="width: 200px;" onchange="this.form.submit()">
                                    <option value="">Pilih Pembicara</option>
                                    @foreach ($pembicaraList as $pembicara)
                                        <option value="{{ $pembicara->id_pembicara }}"
                                            {{ request('pembicara_filter') == $pembicara->id_pembicara ? 'selected' : '' }}>
                                            {{ $pembicara->nama_pembicara }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>

                            <!-- Tombol Tambah Materi -->
                            <a href="#" class="btn bg-gradient-primary btn-sm mb-0" data-bs-toggle="modal"
                                data-bs-target="#createMaterialModal">
                                +&nbsp; Tambah Materi
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
                                        style="width: 250px;">Nama Materi</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Detail Kegiatan</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                                        style="max-width: 300px; word-break: break-word;">Deskripsi</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Pembicara</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($materi as $item)
                                    <tr>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center align-items-center gap-2">
                                                <!-- Edit Materi -->
                                                <a href="{{ route('materi.edit', $item->id_materi) }}"
                                                    class="btn btn-link p-0 m-0">
                                                    <i class="fas fa-edit text-secondary"></i>
                                                </a>

                                                <!-- Delete Materi -->
                                                <form action="{{ route('materi.destroy', $item->id_materi) }}"
                                                    method="POST" class="d-inline-block d-flex align-items-center m-0 p-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link p-0 m-0"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus materi ini?')">
                                                        <i class="fas fa-trash text-secondary"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->nama_materi }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ optional($item->detailKegiatan)->nama_detail_kegiatan ?? 'N/A' }}
                                            </p>
                                        </td>
                                        <td style="max-width: 300px; word-break: break-word; white-space: normal;">
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->deskripsi_materi ?? '-' }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ optional($item->pembicara)->nama_pembicara ?? 'N/A' }}
                                            </p>
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

    <!-- Modal for Creating New Material -->
    <div class="modal fade" id="createMaterialModal" tabindex="-1" role="dialog"
        aria-labelledby="createMaterialModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createMaterialModalLabel">Tambah Materi Baru</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form tambah materi -->
                    <form action="{{ route('materi.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="id_detail_kegiatan" class="form-label">Detail Kegiatan</label>
                            <select class="form-select" id="id_detail_kegiatan" name="id_detail_kegiatan" required>
                                <option value="">Pilih Detail Kegiatan</option>
                                @foreach ($detailKegiatanList as $detailKegiatan)
                                    <option value="{{ $detailKegiatan->id_detail_kegiatan }}">
                                        {{ $detailKegiatan->nama_detail_kegiatan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="nama_materi" class="form-label">Nama Materi</label>
                            <input type="text" class="form-control" id="nama_materi" name="nama_materi" required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi_materi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi_materi" name="deskripsi_materi" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="id_pembicara" class="form-label">Pembicara</label>
                            <select class="form-select" id="id_pembicara" name="id_pembicara" required>
                                <option value="">Pilih Pembicara</option>
                                @foreach ($pembicaraList as $pembicara)
                                    <option value="{{ $pembicara->id_pembicara }}">{{ $pembicara->nama_pembicara }}
                                    </option>
                                @endforeach
                            </select>
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
