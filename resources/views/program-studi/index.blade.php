@extends('layouts.user_type.auth')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Program Studi</h5>
                        </div>
                        <!-- Filter dan Tombol Tambah -->
                        <div class="d-flex align-items-center">
                            <!-- Form Filter -->
                            <form method="GET" action="{{ route('program-studi.index') }}" class="me-3">
                                <input type="text" name="nama_prodi" class="form-control form-control-sm"
                                    placeholder="Cari Program Studi" value="{{ request('nama_prodi') }}" />
                            </form>

                            <!-- Tombol Tambah -->
                            <button type="button" class="btn bg-gradient-primary btn-sm mb-0" data-bs-toggle="modal"
                                data-bs-target="#addProdiModal">
                                +&nbsp; Tambah Program Studi
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center"
                                        style="width: 120px;">Aksi</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                                        style="width: 100px;">ID Prodi</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Nama Program Studi</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Fakultas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($programStudiList as $programStudi)
                                    <tr>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center align-items-center gap-2">
                                                <!-- Edit -->
                                                <a href="{{ route('program-studi.edit', $programStudi->id_prodi) }}"
                                                    class="btn btn-link p-0 m-0">
                                                    <i class="fas fa-edit text-secondary"></i>
                                                </a>

                                                <!-- Delete -->
                                                <form action="{{ route('program-studi.destroy', $programStudi->id_prodi) }}"
                                                    method="POST" class="d-inline-block m-0 p-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link p-0 m-0"
                                                        onclick="return confirm('Yakin ingin menghapus program studi ini?')">
                                                        <i class="fas fa-trash text-secondary"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $programStudi->id_prodi }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $programStudi->nama_prodi }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $programStudi->fakultas->nama_fakultas ?? 'N/A' }}
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

    <!-- Modal Tambah Program Studi -->
    <div class="modal fade" id="addProdiModal" tabindex="-1" aria-labelledby="addProdiModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="addProdiModalLabel">Tambah Program Studi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <form action="{{ route('program-studi.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="id_prodi" class="form-label">ID Prodi</label>
                            <input type="text" class="form-control" id="id_prodi" name="id_prodi" required
                                maxlength="3" placeholder="Misal: 101" />
                        </div>
                        <div class="mb-3">
                            <label for="nama_prodi" class="form-label">Nama Program Studi</label>
                            <input type="text" class="form-control" id="nama_prodi" name="nama_prodi" required
                                placeholder="Nama Program Studi" />
                        </div>
                        <div class="mb-3">
                            <label for="id_fakultas" class="form-label">Fakultas</label>
                            <select class="form-select" id="id_fakultas" name="id_fakultas" required>
                                <option value="">Pilih Fakultas</option>
                                @foreach ($fakultasList as $fakultas)
                                    <option value="{{ $fakultas->id_fakultas }}">{{ $fakultas->nama_fakultas }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Success & Error Messages -->
    @if (session('success'))
        <div class="alert alert-success mt-2 mx-4">
            {{ session('success') }}
        </div>
    @endif

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
