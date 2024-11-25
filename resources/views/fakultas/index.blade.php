@extends('layouts.user_type.auth')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Pengaturan Data Fakultas</h5>
                        <button class="btn bg-gradient-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#createFakultasModal">
                            +&nbsp; Tambah Fakultas
                        </button>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                        Aksi</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                        ID Fakultas</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                        Nama Fakultas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($fakultas as $item)
                                    <tr>
                                        <td class="text-center">
                                            <!-- Tombol Edit -->
                                            <button class="btn btn-link text-secondary p-0" data-bs-toggle="modal"
                                                data-bs-target="#editFakultasModal-{{ $item->id_fakultas }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('fakultas.destroy', $item->id_fakultas) }}"
                                                method="POST" class="d-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-secondary p-0"
                                                    onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->id_fakultas }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->nama_fakultas }}</p>
                                        </td>
                                    </tr>

                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="editFakultasModal-{{ $item->id_fakultas }}" tabindex="-1"
                                        aria-labelledby="editFakultasModalLabel-{{ $item->id_fakultas }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form action="{{ route('fakultas.update', $item->id_fakultas) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="editFakultasModalLabel-{{ $item->id_fakultas }}">Edit Data
                                                            Fakultas</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="id_fakultas-{{ $item->id_fakultas }}"
                                                                class="form-label">ID Fakultas</label>
                                                            <input type="text" class="form-control"
                                                                id="id_fakultas-{{ $item->id_fakultas }}" name="id_fakultas"
                                                                value="{{ $item->id_fakultas }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="nama_fakultas-{{ $item->id_fakultas }}"
                                                                class="form-label">Nama Fakultas</label>
                                                            <input type="text" class="form-control"
                                                                id="nama_fakultas-{{ $item->id_fakultas }}"
                                                                name="nama_fakultas" value="{{ $item->nama_fakultas }}"
                                                                required>
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
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah -->
    <div class="modal fade" id="createFakultasModal" tabindex="-1" aria-labelledby="createFakultasModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('fakultas.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createFakultasModalLabel">Tambah Data Fakultas</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_fakultas" class="form-label">Nama Fakultas</label>
                            <input type="text" class="form-control" id="nama_fakultas" name="nama_fakultas" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
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
@endsection
