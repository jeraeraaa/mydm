@extends('layouts.user_type.auth')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Edit Program Studi</h5>
                </div>
                <div class="card-body px-4 pt-4 pb-2">
                    <form action="{{ route('program-studi.update', $programStudi->id_prodi) }}" method="POST"
                        id="editProdiForm">
                        @csrf
                        @method('PUT')

                        <!-- ID Prodi -->
                        <div class="mb-3">
                            <label for="id_prodi" class="form-label">ID Prodi</label>
                            <input type="text" class="form-control" id="id_prodi" name="id_prodi"
                                value="{{ $programStudi->id_prodi }}" readonly>
                        </div>

                        <!-- Nama Program Studi -->
                        <div class="mb-3">
                            <label for="nama_prodi" class="form-label">Nama Program Studi</label>
                            <input type="text" class="form-control" id="nama_prodi" name="nama_prodi"
                                value="{{ $programStudi->nama_prodi }}" required>
                            <div id="namaProdiError" class="text-danger mt-1"></div>
                        </div>

                        <!-- Fakultas -->
                        <div class="mb-3">
                            <label for="id_fakultas" class="form-label">Fakultas</label>
                            <select class="form-select" id="id_fakultas" name="id_fakultas" required>
                                <option value="">Pilih Fakultas</option>
                                @foreach ($fakultasList as $fakultas)
                                    <option value="{{ $fakultas->id_fakultas }}"
                                        {{ $programStudi->id_fakultas == $fakultas->id_fakultas ? 'selected' : '' }}>
                                        {{ $fakultas->nama_fakultas }}
                                    </option>
                                @endforeach
                            </select>
                            <div id="fakultasError" class="text-danger mt-1"></div>
                        </div>

                        <!-- Tombol Simpan dan Batal -->
                        <div class="d-flex justify-content-end mt-3">
                            <a href="{{ route('program-studi.index') }}" class="btn btn-secondary me-2"><i
                                    class="fa fa-times"></i> Batal</a>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan
                                Perubahan</button>
                        </div>
                    </form>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const namaProdiField = document.getElementById('nama_prodi');
            const namaProdiError = document.getElementById('namaProdiError');
            const fakultasField = document.getElementById('id_fakultas');
            const fakultasError = document.getElementById('fakultasError');

            // Validasi Nama Program Studi
            namaProdiField.addEventListener('input', function() {
                if (namaProdiField.value.trim().length === 0) {
                    namaProdiError.textContent = "Nama Program Studi tidak boleh kosong.";
                    namaProdiField.classList.add('is-invalid');
                } else {
                    namaProdiError.textContent = "";
                    namaProdiField.classList.remove('is-invalid');
                }
            });

            // Validasi Fakultas
            fakultasField.addEventListener('change', function() {
                if (fakultasField.value === "") {
                    fakultasError.textContent = "Fakultas harus dipilih.";
                    fakultasField.classList.add('is-invalid');
                } else {
                    fakultasError.textContent = "";
                    fakultasField.classList.remove('is-invalid');
                }
            });
        });
    </script>
@endsection
