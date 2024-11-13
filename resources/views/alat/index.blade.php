@extends('layouts.user_type.auth')

@section('content')
    <div class="col-12">
        <div class="card mb-4 mx-4">
            <div class="card-header pb-0">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <h5 class="mb-0">All Items</h5>
                        <p class="text-sm">Berikut adalah daftar alat yang tersedia</p>
                    </div>
                    <div class="text-right">
                        <form action="{{ route('alat.index') }}" method="GET" class="d-inline-block">
                            <select name="divisi_filter" class="form-select" onchange="this.form.submit()">
                                <option value="">Semua Divisi</option>
                                @foreach ($bph as $divisi)
                                    <option value="{{ $divisi->id_bph }}"
                                        {{ request('divisi_filter') == $divisi->id_bph ? 'selected' : '' }}>
                                        {{ $divisi->nama_divisi_bph }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach ($alat as $item)
                        <div class="col-xl-3 col-md-6 mb-xl-0 mb-2">
                            <div class="card card-blog card-plain">
                                <div class="position-relative">
                                    <a class="d-block shadow-xl border-radius-xl">
                                        <img src="{{ $item->foto ? url('storage/' . $item->foto) : asset('assets/img/defaultbarang.jpg') }}"
                                            alt="Foto Alat" class="img-fluid shadow border-radius-xl"
                                            style="width: 100%; height: 250px; object-fit: cover;">
                                    </a>
                                </div>
                                <div class="card-body px-1 pb-0">
                                    <p class="text-gradient text-dark mb-2 text-sm">{{ $item->id_alat }}</p>
                                    <a href="javascript:;">
                                        <h5>
                                            {{ $item->nama_alat }}
                                        </h5>
                                    </a>
                                    <p class="mb-3 text-sm">
                                        {{ $item->deskripsi }}
                                    </p>
                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                        <a href="{{ route('alat.show', $item->id_alat) }}"
                                            class="btn btn-outline-primary btn-sm mb-0">Details</a>
                                        <div class="d-flex justify-content-right align-items-center gap-2">
                                            <!-- Edit Activity -->
                                            <a href="{{ route('alat.edit', $item->id_alat) }}" class="btn btn-link p-0 m-0">
                                                <i class="fas fa-edit text-secondary fa-2x"></i>
                                            </a>
                                            <!-- Delete Activity -->
                                            <form action="{{ route('alat.destroy', $item->id_alat) }}" method="POST"
                                                class="d-inline-block d-flex align-items-center m-0 p-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link p-0 m-0"
                                                    onclick="return confirm('Are you sure?')">
                                                    <i class="fas fa-trash text-secondary fa-2x"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">
                        <div class="card h-100 card-plain border">
                            <div class="card-body d-flex flex-column justify-content-center text-center">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#createAlatModal">
                                    <i class="fa fa-plus text-secondary mb-3"></i>
                                    <h5 class="text-secondary">Tambah Alat</h5>
                                </a>
                            </div>
                        </div>
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

    <!-- Modal for Creating New Alat -->
    <div class="modal fade" id="createAlatModal" tabindex="-1" role="dialog" aria-labelledby="createAlatModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createAlatModalLabel">Tambah Alat Baru</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Formulir tambah alat -->
                    <form action="{{ route('alat.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_alat" class="form-label">Nama Alat</label>
                            <input type="text" class="form-control" id="nama_alat" name="nama_alat" required>
                            @error('nama_alat')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3" required></textarea>
                            @error('deskripsi')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="jumlah_tersedia" class="form-label">Jumlah Tersedia</label>
                            <input type="number" class="form-control" id="jumlah_tersedia" name="jumlah_tersedia" required>
                            @error('jumlah_tersedia')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="id_bph" class="form-label">Divisi BPH</label>
                            <select name="id_bph" id="id_bph" class="form-select" required>
                                @foreach ($bph as $divisi)
                                    <option value="{{ $divisi->id_bph }}">{{ $divisi->nama_divisi_bph }}</option>
                                @endforeach
                            </select>
                            @error('id_bph')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto Alat</label>
                            <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                            @error('foto')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
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
