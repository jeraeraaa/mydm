@extends('layouts.user_type.auth')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Pengaturan Data BPH</h5>
                        <button class="btn bg-gradient-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createBphModal">
                            +&nbsp; Tambah BPH
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
                                        ID BPH</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                        Nama Divisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bph as $item)
                                    <tr>
                                        <td class="text-center">
                                            <!-- Tombol Edit -->
                                            <button class="btn btn-link text-secondary p-0" data-bs-toggle="modal"
                                                data-bs-target="#editBphModal-{{ $item->id_bph }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('bph.destroy', $item->id_bph) }}" method="POST"
                                                class="d-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-secondary p-0"
                                                    onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->id_bph }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->nama_divisi_bph }}</p>
                                        </td>
                                    </tr>

                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="editBphModal-{{ $item->id_bph }}" tabindex="-1"
                                        aria-labelledby="editBphModalLabel-{{ $item->id_bph }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form action="{{ route('bph.update', $item->id_bph) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editBphModalLabel-{{ $item->id_bph }}">
                                                            Edit Data BPH</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="id_bph-{{ $item->id_bph }}" class="form-label">ID
                                                                BPH</label>
                                                            <input type="text" class="form-control"
                                                                id="id_bph-{{ $item->id_bph }}" name="id_bph"
                                                                value="{{ $item->id_bph }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="nama_divisi_bph-{{ $item->id_bph }}"
                                                                class="form-label">Nama Divisi</label>
                                                            <input type="text" class="form-control"
                                                                id="nama_divisi_bph-{{ $item->id_bph }}"
                                                                name="nama_divisi_bph" value="{{ $item->nama_divisi_bph }}"
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
    <div class="modal fade" id="createBphModal" tabindex="-1" aria-labelledby="createBphModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('bph.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createBphModalLabel">Tambah Data BPH</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="id_bph" class="form-label">ID BPH</label>
                            <input type="text" class="form-control" id="id_bph" name="id_bph" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama_divisi_bph" class="form-label">Nama Divisi</label>
                            <input type="text" class="form-control" id="nama_divisi_bph" name="nama_divisi_bph"
                                required>
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
