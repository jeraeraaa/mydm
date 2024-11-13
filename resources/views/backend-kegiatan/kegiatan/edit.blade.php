@extends('layouts.user_type.auth')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Edit Kegiatan</h5>
                </div>
                <div class="card-body px-4 pt-4 pb-2">
                    <form action="{{ route('kegiatan.update', $kegiatan->id_kegiatan) }}" method="POST" id="editActivityForm">
                        @csrf
                        @method('PUT')

                        <!-- Nama Kegiatan -->
                        <div class="mb-3">
                            <label for="nama_kegiatan" class="form-label">Nama Kegiatan</label>
                            <input type="text" class="form-control" id="nama_kegiatan" name="nama_kegiatan"
                                value="{{ $kegiatan->nama_kegiatan }}" required>
                            <div id="namaKegiatanError" class="text-danger mt-1"></div>
                        </div>

                        <!-- Kategori Kegiatan -->
                        <div class="mb-3">
                            <label for="id_kategori_kegiatan" class="form-label">Kategori</label>
                            <select class="form-select" id="id_kategori_kegiatan" name="id_kategori_kegiatan" required>
                                <option value="">Pilih Kategori</option>
                                @foreach ($kategori as $kat)
                                    <option value="{{ $kat->id_kategori_kegiatan }}"
                                        {{ $kegiatan->id_kategori_kegiatan == $kat->id_kategori_kegiatan ? 'selected' : '' }}>
                                        {{ $kat->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            <div id="kategoriError" class="text-danger mt-1"></div>
                        </div>

                        <!-- Deskripsi Kegiatan -->
                        <div class="mb-3">
                            <label for="deskripsi_kegiatan" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi_kegiatan" name="deskripsi_kegiatan" rows="3">{{ $kegiatan->deskripsi_kegiatan }}</textarea>
                            <div id="deskripsiError" class="text-danger mt-1"></div>
                        </div>

                        <!-- Tombol Simpan dan Batal -->
                        <div class="d-flex justify-content-end mt-3">
                            <a href="{{ route('kegiatan.index') }}" class="btn btn-secondary me-2"><i
                                    class="fa fa-times"></i> Cancel</a>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Pesan Sukses setelah Tabel -->
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const namaKegiatanField = document.getElementById('nama_kegiatan');
            const namaKegiatanError = document.getElementById('namaKegiatanError');
            const kategoriField = document.getElementById('id_kategori_kegiatan');
            const kategoriError = document.getElementById('kategoriError');
            const deskripsiField = document.getElementById('deskripsi_kegiatan');
            const deskripsiError = document.getElementById('deskripsiError');

            // Validasi Nama Kegiatan secara langsung
            namaKegiatanField.addEventListener('input', function() {
                const kegiatanValue = namaKegiatanField.value.trim();
                if (kegiatanValue.length === 0) {
                    namaKegiatanError.textContent = "Nama kegiatan tidak boleh kosong.";
                    namaKegiatanField.classList.add('is-invalid');
                } else {
                    namaKegiatanError.textContent = "";
                    namaKegiatanField.classList.remove('is-invalid');
                }
            });

            // Validasi Kategori Kegiatan
            kategoriField.addEventListener('change', function() {
                if (kategoriField.value === "") {
                    kategoriError.textContent = "Kategori harus dipilih.";
                    kategoriField.classList.add('is-invalid');
                } else {
                    kategoriError.textContent = "";
                    kategoriField.classList.remove('is-invalid');
                }
            });

            // Validasi Deskripsi Kegiatan
            deskripsiField.addEventListener('input', function() {
                const deskripsiValue = deskripsiField.value.trim();
                if (deskripsiValue.length > 500) {
                    deskripsiError.textContent = "Deskripsi maksimal 500 karakter.";
                    deskripsiField.classList.add('is-invalid');
                } else {
                    deskripsiError.textContent = "";
                    deskripsiField.classList.remove('is-invalid');
                }
            });
        });
    </script>
@endsection
