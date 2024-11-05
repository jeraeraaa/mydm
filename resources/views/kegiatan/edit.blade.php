@extends('layouts.user_type.auth')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Edit Kegiatan</h5>
                </div>
                <div class="card-body px-4 pt-4 pb-2">
                    <form action="{{ route('kegiatan.update', $kegiatan->id_kegiatan) }}" method="POST"
                        enctype="multipart/form-data" id="editForm" onsubmit="return validateForm()">
                        @csrf
                        @method('PUT')

                        <!-- Nama Kegiatan -->
                        <div class="mb-3">
                            <label for="nama_kegiatan" class="form-label">Nama Kegiatan</label>
                            <input type="text" class="form-control" id="nama_kegiatan" name="nama_kegiatan"
                                value="{{ $kegiatan->nama_kegiatan }}" required>
                            <div id="namaKegiatanError" class="text-danger mt-1"></div>
                        </div>

                        <!-- Kategori -->
                        <div class="mb-3">
                            <label for="id_kategori_kegiatan" class="form-label">Kategori</label>
                            <select name="id_kategori_kegiatan" id="id_kategori_kegiatan" class="form-select" required
                                onchange="toggleBphDivisi()">
                                <option value="">Pilih Kategori</option>
                                @foreach ($kategori as $k)
                                    <option value="{{ $k->id_kategori_kegiatan }}"
                                        {{ $kegiatan->id_kategori_kegiatan == $k->id_kategori_kegiatan ? 'selected' : '' }}>
                                        {{ $k->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            <div id="kategoriError" class="text-danger mt-1"></div>
                        </div>

                        <!-- Divisi BPH -->
                        <div class="mb-3" id="bphDivisiContainer" style="display: none;">
                            <label for="id_bph" class="form-label">Divisi BPH</label>
                            <select name="id_bph" id="id_bph" class="form-select">
                                <option value="">Pilih Divisi BPH</option>
                                @foreach ($bph as $divisi)
                                    <option value="{{ $divisi->id_bph }}"
                                        {{ optional($kegiatan->detail_kegiatan)->id_bph == $divisi->id_bph ? 'selected' : '' }}>
                                        {{ $divisi->nama_divisi_bph }}
                                    </option>
                                @endforeach
                            </select>
                            <div id="bphError" class="text-danger mt-1"></div>
                        </div>

                        <!-- Deskripsi Kegiatan -->
                        <div class="mb-3">
                            <label for="deskripsi_kegiatan" class="form-label">Deskripsi Kegiatan</label>
                            <textarea name="deskripsi_kegiatan" id="deskripsi_kegiatan" class="form-control" rows="3">{{ $kegiatan->deskripsi_kegiatan }}</textarea>
                        </div>

                        <!-- Tanggal Mulai -->
                        <div class="mb-3">
                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai"
                                value="{{ optional($kegiatan->detail_kegiatan)->tanggal_mulai }}" required>
                        </div>

                        <!-- Waktu Mulai -->
                        <div class="mb-3">
                            <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                            <input type="time" class="form-control" id="waktu_mulai" name="waktu_mulai"
                                value="{{ optional($kegiatan->detail_kegiatan)->waktu_mulai }}" required>
                        </div>

                        <!-- Tanggal Selesai -->
                        <div class="mb-3">
                            <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai"
                                value="{{ optional($kegiatan->detail_kegiatan)->tanggal_selesai }}" required>
                            <div id="tanggalError" class="text-danger mt-1"></div>
                        </div>

                        <!-- Waktu Selesai -->
                        <div class="mb-3">
                            <label for="waktu_selesai" class="form-label">Waktu Selesai</label>
                            <input type="time" class="form-control" id="waktu_selesai" name="waktu_selesai"
                                value="{{ optional($kegiatan->detail_kegiatan)->waktu_selesai }}" required>
                            <div id="waktuError" class="text-danger mt-1"></div>
                        </div>

                        <!-- Lokasi -->
                        <div class="mb-3">
                            <label for="lokasi" class="form-label">Lokasi</label>
                            <input type="text" class="form-control" id="lokasi" name="lokasi"
                                value="{{ optional($kegiatan->detail_kegiatan)->lokasi }}" required>
                        </div>

                        {{-- Foto --}}
                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto Kegiatan</label>
                            <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                            @if ($kegiatan->detail_kegiatan && $kegiatan->detail_kegiatan->foto)
                                <p class="mt-2">Foto saat ini: <img
                                        src="{{ asset('storage/' . $kegiatan->detail_kegiatan->foto) }}" width="100">
                                </p>
                            @endif
                            <div id="fotoError" class="text-danger"></div>
                        </div>

                        <div class="d-flex justify-content-end mt-3">
                            <a href="{{ route('kegiatan.index') }}" class="btn btn-secondary me-2">
                                <i class="fa fa-times"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Save Changes
                            </button>
                        </div>

                    </form>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function toggleBphDivisi() {
            const kategoriSelect = document.getElementById('id_kategori_kegiatan');
            const bphDivisiContainer = document.getElementById('bphDivisiContainer');
            const bphSelect = document.getElementById('id_bph');
            const kategoriError = document.getElementById('kategoriError');

            const selectedCategory = kategoriSelect.options[kategoriSelect.selectedIndex].text;
            if (selectedCategory === 'BPH') {
                bphDivisiContainer.style.display = 'block';
                bphSelect.required = true;
            } else {
                bphDivisiContainer.style.display = 'none';
                bphSelect.value = ""; // Reset value if hidden
                bphSelect.required = false;
                kategoriError.innerText = "";
            }
        }

        function validateForm() {
            const kategoriSelect = document.getElementById('id_kategori_kegiatan');
            const bphSelect = document.getElementById('id_bph');
            const tanggalMulai = document.getElementById('tanggal_mulai');
            const waktuMulai = document.getElementById('waktu_mulai');
            const tanggalSelesai = document.getElementById('tanggal_selesai');
            const waktuSelesai = document.getElementById('waktu_selesai');
            const fotoInput = document.getElementById('foto'); // ID untuk input foto
            const fotoError = document.getElementById('fotoError'); // Element untuk pesan error foto

            let valid = true;
            const kategoriError = document.getElementById('kategoriError');
            const bphError = document.getElementById('bphError');
            const tanggalError = document.getElementById('tanggalError');
            const waktuError = document.getElementById('waktuError');

            // Reset errors
            kategoriError.innerText = "";
            bphError.innerText = "";
            tanggalError.innerText = "";
            waktuError.innerText = "";
            fotoError.innerText = "";

            // Validasi kategori dan divisi BPH
            if (kategoriSelect.options[kategoriSelect.selectedIndex].text === 'BPH' && bphSelect.value === "") {
                bphError.innerText = "Divisi BPH harus dipilih jika kategori adalah BPH.";
                valid = false;
            }

            // Validasi tanggal
            if (tanggalMulai.value && tanggalSelesai.value && (tanggalSelesai.value < tanggalMulai.value)) {
                tanggalError.innerText = "Tanggal selesai tidak boleh lebih awal dari tanggal mulai.";
                valid = false;
            }

            // Validasi waktu
            if (tanggalMulai.value === tanggalSelesai.value && waktuMulai.value && waktuSelesai.value && waktuSelesai
                .value <= waktuMulai.value) {
                waktuError.innerText = "Waktu selesai harus lebih lambat dari waktu mulai pada tanggal yang sama.";
                valid = false;
            }

            // Validasi foto
            if (fotoInput.files.length > 0) {
                const file = fotoInput.files[0];
                const maxSize = 2 * 1024 * 1024; // 2MB
                const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

                // Validasi ukuran file
                if (file.size > maxSize) {
                    fotoError.innerText = "Ukuran file tidak boleh lebih dari 2MB.";
                    fotoInput.classList.add('is-invalid');
                    valid = false;
                } else {
                    fotoInput.classList.remove('is-invalid');
                }

                // Validasi tipe file
                if (!allowedTypes.includes(file.type)) {
                    fotoError.innerText = "Format file tidak valid. Hanya JPEG, PNG, atau GIF yang diizinkan.";
                    fotoInput.classList.add('is-invalid');
                    valid = false;
                } else {
                    fotoInput.classList.remove('is-invalid');
                }
            }

            return valid;
        }

        // Event listener untuk validasi foto langsung saat pengguna memilih file
        document.getElementById('foto').addEventListener('change', function(event) {
            const fotoInput = event.target;
            const fotoError = document.getElementById('fotoError');
            const file = fotoInput.files[0];

            // Reset error message
            fotoError.innerText = '';
            fotoInput.classList.remove('is-invalid');

            if (file) {
                // Validasi ukuran file (2MB)
                const maxSize = 2 * 1024 * 1024;
                if (file.size > maxSize) {
                    fotoError.innerText = 'Ukuran file tidak boleh lebih dari 2MB.';
                    fotoInput.classList.add('is-invalid');
                    fotoInput.value = ''; // Reset file input
                    return;
                }

                // Validasi tipe file
                const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (!allowedTypes.includes(file.type)) {
                    fotoError.innerText = 'Format file tidak valid. Hanya JPEG, PNG, atau GIF yang diizinkan.';
                    fotoInput.classList.add('is-invalid');
                    fotoInput.value = ''; // Reset file input
                    return;
                }
            }
        });
    </script>

@endsection
