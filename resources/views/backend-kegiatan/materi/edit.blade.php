@extends('layouts.user_type.auth')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Edit Materi</h5>
                </div>
                <div class="card-body px-4 pt-4 pb-2">
                    <form action="{{ route('materi.update', $materi->id_materi) }}" method="POST" id="editMaterialForm">
                        @csrf
                        @method('PUT')

                        <!-- Nama Materi -->
                        <div class="mb-3">
                            <label for="nama_materi" class="form-label">Nama Materi</label>
                            <input type="text" class="form-control" id="nama_materi" name="nama_materi"
                                value="{{ $materi->nama_materi }}" required>
                            <div id="namaMateriError" class="text-danger mt-1"></div>
                        </div>

                        <!-- Detail Kegiatan -->
                        <div class="mb-3">
                            <label for="id_detail_kegiatan" class="form-label">Detail Kegiatan</label>
                            <select class="form-select" id="id_detail_kegiatan" name="id_detail_kegiatan" required>
                                <option value="">Pilih Detail Kegiatan</option>
                                @foreach ($detailKegiatanList as $detailKegiatan)
                                    <option value="{{ $detailKegiatan->id_detail_kegiatan }}"
                                        {{ $materi->id_detail_kegiatan == $detailKegiatan->id_detail_kegiatan ? 'selected' : '' }}>
                                        {{ $detailKegiatan->nama_detail_kegiatan }}
                                    </option>
                                @endforeach
                            </select>
                            <div id="detailKegiatanError" class="text-danger mt-1"></div>
                        </div>

                        <!-- Deskripsi Materi -->
                        <div class="mb-3">
                            <label for="deskripsi_materi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi_materi" name="deskripsi_materi" rows="3">{{ $materi->deskripsi_materi }}</textarea>
                            <div id="deskripsiError" class="text-danger mt-1"></div>
                        </div>

                        <!-- Pembicara -->
                        <div class="mb-3">
                            <label for="id_pembicara" class="form-label">Pembicara</label>
                            <select class="form-select" id="id_pembicara" name="id_pembicara" required>
                                <option value="">Pilih Pembicara</option>
                                @foreach ($pembicaraList as $pembicara)
                                    <option value="{{ $pembicara->id_pembicara }}"
                                        {{ $materi->id_pembicara == $pembicara->id_pembicara ? 'selected' : '' }}>
                                        {{ $pembicara->nama_pembicara }}
                                    </option>
                                @endforeach
                            </select>
                            <div id="pembicaraError" class="text-danger mt-1"></div>
                        </div>

                        <!-- Tombol Simpan dan Batal -->
                        <div class="d-flex justify-content-end mt-3">
                            <a href="{{ route('materi.index') }}" class="btn btn-secondary me-2"><i class="fa fa-times"></i>
                                Cancel</a>
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
            const namaMateriField = document.getElementById('nama_materi');
            const namaMateriError = document.getElementById('namaMateriError');
            const detailKegiatanField = document.getElementById('id_detail_kegiatan');
            const detailKegiatanError = document.getElementById('detailKegiatanError');
            const deskripsiField = document.getElementById('deskripsi_materi');
            const deskripsiError = document.getElementById('deskripsiError');
            const pembicaraField = document.getElementById('id_pembicara');
            const pembicaraError = document.getElementById('pembicaraError');

            // Validasi Nama Materi
            namaMateriField.addEventListener('input', function() {
                if (namaMateriField.value.trim().length === 0) {
                    namaMateriError.textContent = "Nama materi tidak boleh kosong.";
                    namaMateriField.classList.add('is-invalid');
                } else {
                    namaMateriError.textContent = "";
                    namaMateriField.classList.remove('is-invalid');
                }
            });

            // Validasi Detail Kegiatan
            detailKegiatanField.addEventListener('change', function() {
                if (detailKegiatanField.value === "") {
                    detailKegiatanError.textContent = "Detail kegiatan harus dipilih.";
                    detailKegiatanField.classList.add('is-invalid');
                } else {
                    detailKegiatanError.textContent = "";
                    detailKegiatanField.classList.remove('is-invalid');
                }
            });

            // Validasi Deskripsi Materi
            deskripsiField.addEventListener('input', function() {
                if (deskripsiField.value.trim().length > 500) {
                    deskripsiError.textContent = "Deskripsi maksimal 500 karakter.";
                    deskripsiField.classList.add('is-invalid');
                } else {
                    deskripsiError.textContent = "";
                    deskripsiField.classList.remove('is-invalid');
                }
            });

            // Validasi Pembicara
            pembicaraField.addEventListener('change', function() {
                if (pembicaraField.value === "") {
                    pembicaraError.textContent = "Pembicara harus dipilih.";
                    pembicaraField.classList.add('is-invalid');
                } else {
                    pembicaraError.textContent = "";
                    pembicaraField.classList.remove('is-invalid');
                }
            });
        });
    </script>
@endsection
