@extends('layouts.user_type.auth')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">All Activities</h5>
                        </div>
                        <!-- Tombol New Activity yang membuka modal -->
                        <a href="#" class="btn bg-gradient-primary btn-sm mb-0" data-bs-toggle="modal"
                            data-bs-target="#createActivityModal">
                            +&nbsp; New Activity
                        </a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center"
                                        style="width: 100px;">Actions
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Name</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Category</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Division (BPH)</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Start Date</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Start Time</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">End
                                        Date</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">End
                                        Time</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Location</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Foto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kegiatan as $item)
                                    <tr>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center align-items-center gap-2">
                                                <!-- Edit Activity -->
                                                <a href="{{ route('kegiatan.edit', $item->id_kegiatan) }}"
                                                    class="btn btn-link p-0 m-0">
                                                    <i class="fas fa-edit text-secondary"></i>
                                                </a>

                                                <!-- Delete Activity -->
                                                <form action="{{ route('kegiatan.destroy', $item->id_kegiatan) }}"
                                                    method="POST" class="d-inline-block d-flex align-items-center m-0 p-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link p-0 m-0"
                                                        onclick="return confirm('Are you sure?')">
                                                        <i class="fas fa-trash text-secondary"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->nama_kegiatan }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ optional($item->kategori)->nama_kategori ?? 'N/A' }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ optional(optional($item->detail_kegiatan)->bph)->nama_divisi_bph ?? '-' }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ optional($item->detail_kegiatan)->tanggal_mulai ? \Carbon\Carbon::parse(optional($item->detail_kegiatan)->tanggal_mulai)->format('d/m/Y') : '-' }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ optional($item->detail_kegiatan)->waktu_mulai ? \Carbon\Carbon::parse(optional($item->detail_kegiatan)->waktu_mulai)->format('H:i') : '-' }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ optional($item->detail_kegiatan)->tanggal_selesai ? \Carbon\Carbon::parse(optional($item->detail_kegiatan)->tanggal_selesai)->format('d/m/Y') : '-' }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ optional($item->detail_kegiatan)->waktu_selesai ? \Carbon\Carbon::parse(optional($item->detail_kegiatan)->waktu_selesai)->format('H:i') : '-' }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ optional($item->detail_kegiatan)->lokasi ?? '-' }}</p>
                                        </td>
                                        <td> <!-- Tambahkan kolom untuk menampilkan foto -->
                                            @if (optional($item->detail_kegiatan)->foto)
                                                <img src="{{ asset('storage/foto_kegiatan/' . $item->detail_kegiatan->foto) }}"
                                                    alt="Foto Kegiatan" style="width: 50px; height: auto;">
                                            @else
                                                <span>-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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

    <!-- Pesan Sukses setelah Tabel -->
    @if (session('success'))
        <div class="alert alert-success mt-2 mx-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Modal for Creating New Activity -->
    <div class="modal fade" id="createActivityModal" tabindex="-1" role="dialog"
        aria-labelledby="createActivityModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createActivityModalLabel">Tambah Kegiatan Baru</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Formulir tambah kegiatan -->
                    <form id="activityForm" action="{{ route('kegiatan.store') }}" method="POST"
                        enctype="multipart/form-data" onsubmit="return validateForm()">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_kegiatan" class="form-label">Nama Kegiatan</label>
                            <input type="text" class="form-control" id="nama_kegiatan" name="nama_kegiatan" required>
                        </div>
                        <div class="mb-3">
                            <label for="id_kategori_kegiatan" class="form-label">Kategori</label>
                            <select class="form-select" id="id_kategori_kegiatan" name="id_kategori_kegiatan" required
                                onchange="toggleBphDivisi()">
                                <option value="">Pilih Kategori</option>
                                @foreach ($kategori as $k)
                                    <option value="{{ $k->id_kategori_kegiatan }}">{{ $k->nama_kategori }}</option>
                                @endforeach
                            </select>
                            <div id="kategoriError" class="text-danger"></div>
                        </div>

                        <!-- Dropdown Divisi BPH yang akan muncul jika kategori adalah BPH -->
                        <div class="mb-3" id="bphDivisiContainer" style="display: none;">
                            <label for="id_bph" class="form-label">Divisi BPH</label>
                            <select class="form-select" id="id_bph" name="id_bph">
                                <option value="">Pilih Divisi BPH</option>
                                @foreach ($bph as $divisi)
                                    <option value="{{ $divisi->id_bph }}">{{ $divisi->nama_divisi_bph }}</option>
                                @endforeach
                            </select>
                            <div id="bphError" class="text-danger"></div>
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi_kegiatan" class="form-label">Deskripsi Kegiatan</label>
                            <textarea class="form-control" id="deskripsi_kegiatan" name="deskripsi_kegiatan" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
                        </div>
                        <div class="mb-3">
                            <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                            <input type="time" class="form-control" id="waktu_mulai" name="waktu_mulai" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai"
                                required>
                            <div id="tanggalError" class="text-danger"></div>
                        </div>
                        <div class="mb-3">
                            <label for="waktu_selesai" class="form-label">Waktu Selesai</label>
                            <input type="time" class="form-control" id="waktu_selesai" name="waktu_selesai" required>
                            <div id="waktuError" class="text-danger"></div>
                        </div>
                        <div class="mb-3">
                            <label for="lokasi" class="form-label">Lokasi</label>
                            <input type="text" class="form-control" id="lokasi" name="lokasi" required>
                        </div>
                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto Kegiatan</label>
                            <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                            <div id="fotoError" class="text-danger"></div>
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
