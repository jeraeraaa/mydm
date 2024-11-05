@extends('layouts.user_type.auth')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Edit Alat</h5>
                </div>
                <div class="card-body px-4 pt-4 pb-2">
                    <form action="{{ route('alat.update', $alat->id_alat) }}" method="POST"
                        enctype="multipart/form-data" id="editForm">
                        @csrf
                        @method('PUT')

                        <!-- ID Alat (Primary Key) - Read Only -->
                        <div class="mb-3">
                            <label for="id_alat" class="form-label">ID Alat</label>
                            <input type="text" class="form-control" id="id_alat" name="id_alat"
                                value="{{ $alat->id_alat }}" readonly>
                        </div>

                        <!-- Nama Alat -->
                        <div class="mb-3">
                            <label for="nama_alat" class="form-label">Nama Alat</label>
                            <input type="text" class="form-control" id="nama_alat" name="nama_alat"
                                value="{{ $alat->nama_alat }}" required>
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3" required>{{ $alat->deskripsi }}</textarea>
                        </div>

                        <!-- Jumlah Tersedia -->
                        <div class="mb-3">
                            <label for="jumlah_tersedia" class="form-label">Jumlah Tersedia</label>
                            <input type="number" class="form-control" id="jumlah_tersedia" name="jumlah_tersedia"
                                value="{{ $alat->jumlah_tersedia }}" required>
                        </div>

                        <!-- Divisi BPH - Non-editable -->
                        <div class="mb-3">
                            <label for="id_bph" class="form-label">Divisi BPH</label>
                            <input type="text" class="form-control" id="id_bph" name="id_bph"
                                value="{{ $alat->bph->nama_divisi_bph }}" readonly>
                        </div>

                        <!-- Foto Alat -->
                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto Alat</label>
                            <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                            @if ($alat->foto)
                                <p class="mt-2">Current photo:
                                    <img src="{{ asset('storage/alats/' . $alat->foto) }}" width="100">
                                </p>
                            @endif
                        </div>

                        <div class="d-flex justify-content-end mt-3">
                            <a href="{{ route('alat.index') }}" class="btn btn-secondary me-2"><i
                                    class="fa fa-times"></i> Cancel</a>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
