@extends('layouts.user_type.auth')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <h5 class="mb-0">Pengaturan Data Ketua Umum</h5>
                        <!-- Tombol Tambah Ketua Umum -->
                        <a href="#" class="btn bg-gradient-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#createKetumModal">
                            +&nbsp; Tambah Ketua Umum
                        </a>
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
                                        ID Ketua Umum</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                        ID Anggota</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                        Nama Anggota</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                        Tahun Jabatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ketuaUmum as $ketum)
                                    <tr>
                                        <td class="text-center">
                                            <!-- Tombol Edit -->
                                            <a href="#" class="btn btn-link p-0 m-0 text-secondary"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editKetumModal-{{ $ketum->id_ketum }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('ketua-umum.destroy', $ketum->id_ketum) }}"
                                                method="POST" class="d-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link p-0 m-0 text-secondary"
                                                    onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $ketum->id_ketum }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $ketum->id_anggota }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $ketum->anggota->nama_anggota ?? '-' }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $ketum->tahun_jabatan }}</p>
                                        </td>
                                    </tr>

                                    <!-- Modal Edit Ketua Umum -->
                                    <div class="modal fade" id="editKetumModal-{{ $ketum->id_ketum }}" tabindex="-1"
                                        aria-labelledby="editKetumModalLabel-{{ $ketum->id_ketum }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form action="{{ route('ketua-umum.update', $ketum->id_ketum) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="editKetumModalLabel-{{ $ketum->id_ketum }}">Edit Ketua Umum
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- Input ID Anggota -->
                                                        <div class="mb-3">
                                                            <label for="id_anggota-{{ $ketum->id_ketum }}"
                                                                class="form-label">ID Anggota (NIM)</label>
                                                            <input type="text" class="form-control"
                                                                id="id_anggota-{{ $ketum->id_ketum }}" name="id_anggota"
                                                                value="{{ $ketum->id_anggota }}" required>
                                                            <div id="nimError-{{ $ketum->id_ketum }}"
                                                                class="text-danger mt-1"></div>
                                                        </div>
                                                        <!-- Input Tahun Jabatan -->
                                                        <div class="mb-3">
                                                            <label for="tahun_jabatan-{{ $ketum->id_ketum }}"
                                                                class="form-label">Tahun Jabatan</label>
                                                            <input type="number" class="form-control"
                                                                id="tahun_jabatan-{{ $ketum->id_ketum }}"
                                                                name="tahun_jabatan" value="{{ $ketum->tahun_jabatan }}"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary"
                                                            id="submitButton-{{ $ketum->id_ketum }}">Simpan</button>
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

    @if ($errors->any())
        <div class="alert alert-danger mt-2 mx-4">
            <ul class="m-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif




    <!-- Modal Tambah Ketua Umum -->
    <div class="modal fade" id="createKetumModal" tabindex="-1" aria-labelledby="createKetumModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('ketua-umum.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createKetumModalLabel">Tambah Ketua Umum</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Input ID Anggota -->
                        <div class="mb-3">
                            <label for="id_anggota" class="form-label">ID Anggota (NIM)</label>
                            <input type="text" class="form-control" id="id_anggota" name="id_anggota" required>
                            <!-- Ruang untuk pesan error -->
                            <div id="nimError" class="text-danger mt-1"></div>
                        </div>
                        <!-- Input Tahun Jabatan -->
                        <div class="mb-3">
                            <label for="tahun_jabatan" class="form-label">Tahun Jabatan</label>
                            <input type="number" class="form-control" id="tahun_jabatan" name="tahun_jabatan" required
                                minlength="4" maxlength="4" min="1000" max="9999"
                                oninput="validateYearLength(this)">
                            <div id="tahunError" class="text-danger mt-1"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="submitButton" disabled>Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modals = document.querySelectorAll('.modal'); // Ambil semua modal

            modals.forEach((modal) => {
                const modalId = modal.id.split('-')[1]; // Ambil ID unik modal
                const nimField = document.getElementById(`id_anggota-${modalId}`);
                const nimError = document.getElementById(`nimError-${modalId}`);
                const submitButton = document.getElementById(`submitButton-${modalId}`);

                if (nimField) {
                    // Fungsi debounce untuk validasi
                    function debounce(func, delay) {
                        let timeout;
                        return function(...args) {
                            clearTimeout(timeout);
                            timeout = setTimeout(() => func.apply(this, args), delay);
                        };
                    }

                    // Validasi input NIM
                    nimField.addEventListener(
                        'input',
                        debounce(function() {
                            const nimValue = nimField.value;
                            nimError.textContent = ''; // Reset pesan error
                            nimField.classList.remove('is-invalid'); // Reset invalid class
                            submitButton.disabled = true; // Disable submit button

                            // Validasi panjang NIM
                            if (nimValue.length !== 9 || isNaN(nimValue)) {
                                nimError.textContent = 'NIM harus berupa 9 digit angka.';
                                nimField.classList.add('is-invalid');
                                return;
                            }

                            // Validasi kode prodi
                            const kodeProdi = nimValue.substring(0, 3);
                            const validProdi = [
                                '115',
                                '125',
                                '205',
                                '315',
                                '325',
                                '345',
                                '405',
                                '515',
                                '525',
                                '535',
                                '545',
                                '615',
                                '625',
                                '705',
                                '825',
                                '915',
                            ];
                            if (!validProdi.includes(kodeProdi)) {
                                nimError.textContent =
                                    'NIM tidak sesuai dengan kode prodi yang valid.';
                                nimField.classList.add('is-invalid');
                                return;
                            }

                            // Validasi ke server untuk mengecek NIM di database
                            checkNimExists(nimValue, modalId);
                        }, 500)
                    );
                }

                function checkNimExists(nim, modalId) {
                    fetch(`/check-nim?nim=${nim}`, {
                            method: 'GET',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                            },
                        })
                        .then((response) => response.json())
                        .then((data) => {
                            if (data.exists) {
                                nimError.textContent =
                                    'NIM ini sudah terdaftar atau memiliki role tertentu.';
                                nimField.classList.add('is-invalid');
                                submitButton.disabled = true; // Disable jika NIM sudah ada
                            } else {
                                nimError.textContent = '';
                                nimField.classList.remove('is-invalid');
                                submitButton.disabled = false; // Enable jika valid
                            }
                        })
                        .catch((error) => {
                            console.error('Error:', error);
                            nimError.textContent = 'Terjadi kesalahan saat memvalidasi NIM.';
                            nimField.classList.add('is-invalid');
                            submitButton.disabled = true;
                        });
                }
            });
        });


        //yang tambah
        document.addEventListener('DOMContentLoaded', function() {
            const nimField = document.getElementById('id_anggota');
            const nimError = document.getElementById('nimError');
            const submitButton = document.getElementById('submitButton');

            // Fungsi debounce untuk menunda eksekusi
            function debounce(func, delay) {
                let timeout;
                return function(...args) {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(this, args), delay);
                };
            }

            // Validasi input NIM saat mengetik
            nimField.addEventListener(
                'input',
                debounce(function() {
                    const nimValue = nimField.value;
                    nimError.textContent = ''; // Reset pesan error
                    nimField.classList.remove('is-invalid'); // Reset status invalid
                    submitButton.disabled = true; // Disable tombol submit secara default

                    // Validasi panjang NIM
                    if (nimValue.length !== 9 || isNaN(nimValue)) {
                        nimError.textContent = 'NIM harus berupa 9 digit angka.';
                        nimField.classList.add('is-invalid');
                        return;
                    }

                    // Validasi kode prodi dari NIM
                    const kodeProdi = nimValue.substring(0, 3);
                    const validProdi = [
                        '115',
                        '125',
                        '205',
                        '315',
                        '325',
                        '345',
                        '405',
                        '515',
                        '525',
                        '535',
                        '545',
                        '615',
                        '625',
                        '705',
                        '825',
                        '915',
                    ];
                    if (!validProdi.includes(kodeProdi)) {
                        nimError.textContent = 'NIM tidak sesuai dengan kode prodi yang valid.';
                        nimField.classList.add('is-invalid');
                        return;
                    }

                    // Panggil fungsi untuk memvalidasi NIM di server
                    checkNimExists(nimValue);
                }, 500)
            );

            // Fungsi untuk memeriksa apakah NIM sudah ada di database
            function checkNimExists(nim) {
                fetch(`/check-nim?nim=${nim}`, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                    })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.exists) {
                            nimError.textContent = 'NIM ini sudah terdaftar atau memiliki role tertentu.';
                            nimField.classList.add('is-invalid');
                            submitButton.disabled = true; // Disable tombol submit jika NIM sudah ada
                        } else {
                            nimError.textContent = '';
                            nimField.classList.remove('is-invalid');
                            submitButton.disabled = false; // Enable tombol submit jika valid
                        }
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                        nimError.textContent = 'Terjadi kesalahan saat memvalidasi NIM.';
                        nimField.classList.add('is-invalid');
                        submitButton.disabled = true;
                    });
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const tahunField = document.getElementById('tahun_jabatan');
            const tahunError = document.getElementById('tahunError');
            const submitButton = document.getElementById('submitButton');

            // Fungsi untuk validasi panjang input tahun
            function validateYearLength(input) {
                const value = input.value;

                tahunError.textContent = ''; // Reset pesan error
                if (value.length !== 4 || value < 1000 || value > 9999) {
                    tahunError.textContent = 'Tahun harus berupa 4 digit angka valid.';
                    input.classList.add('is-invalid');
                    submitButton.disabled = true;
                } else {
                    input.classList.remove('is-invalid');
                    tahunError.textContent = '';
                    submitButton.disabled = false;
                }
            }

            // Event listener untuk validasi langsung saat mengetik
            tahunField.addEventListener('input', function() {
                validateYearLength(tahunField);
            });
        });
    </script>
@endsection
