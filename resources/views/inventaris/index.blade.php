@extends('layouts.user_type.auth')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <h5 class="mb-0">Pengaturan Data Inventaris</h5>
                        <!-- Tombol Tambah Inventaris -->
                        <a href="#" class="btn bg-gradient-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#createInventarisModal">
                            +&nbsp; Tambah Inventaris
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
                                        ID Inventaris</th>
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
                                @foreach ($inventaris as $item)
                                    <tr>
                                        <td class="text-center">
                                            <!-- Tombol Edit -->
                                            <a href="#" class="btn btn-link p-0 m-0 text-secondary"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editInventarisModal-{{ $item->id_inventaris }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('inventaris.destroy', $item->id_inventaris) }}"
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
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->id_inventaris }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->id_anggota }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $item->anggota->nama_anggota ?? '-' }}
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->tahun_jabatan }}</p>
                                        </td>
                                    </tr>
                                    {{-- Modal Edit Inventaris --}}
                                    <div class="modal fade" id="editInventarisModal-{{ $item->id_inventaris }}"
                                        tabindex="-1" aria-labelledby="editInventarisModalLabel-{{ $item->id_inventaris }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form action="{{ route('inventaris.update', $item->id_inventaris) }}"
                                                method="POST" id="editForm-{{ $item->id_inventaris }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="editInventarisModalLabel-{{ $item->id_inventaris }}">Edit
                                                            Inventaris</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- Input ID Anggota -->
                                                        <div class="mb-3">
                                                            <label for="id_anggota-{{ $item->id_inventaris }}"
                                                                class="form-label">ID Anggota (NIM)</label>
                                                            <input type="text" name="id_anggota"
                                                                id="id_anggota-{{ $item->id_inventaris }}"
                                                                class="form-control" value="{{ $item->id_anggota }}"
                                                                required
                                                                oninput="validateNIM(this, '{{ $item->id_inventaris }}')">
                                                            <div id="nimError-{{ $item->id_inventaris }}"
                                                                class="text-danger mt-1"></div>
                                                        </div>
                                                        <!-- Input Tahun Jabatan -->
                                                        <div class="mb-3">
                                                            <label for="tahun_jabatan-{{ $item->id_inventaris }}"
                                                                class="form-label">Tahun Jabatan</label>
                                                            <input type="number" name="tahun_jabatan"
                                                                id="tahun_jabatan-{{ $item->id_inventaris }}"
                                                                class="form-control" value="{{ $item->tahun_jabatan }}"
                                                                required minlength="4" maxlength="4" min="1900"
                                                                max="{{ date('Y') }}" oninput="validateYear(this)">
                                                            <div id="tahunError-{{ $item->id_inventaris }}"
                                                                class="text-danger mt-1"></div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary"
                                                            id="submitButton-{{ $item->id_inventaris }}">Simpan</button>
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

    <!-- Pesan Sukses -->

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


    <!-- Modal Tambah Inventaris -->
    <div class="modal fade" id="createInventarisModal" tabindex="-1" aria-labelledby="createInventarisModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('inventaris.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createInventarisModalLabel">Tambah Inventaris</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="id_anggota" class="form-label">ID Anggota (NIM)</label>
                            <input type="text" class="form-control" id="id_anggota" name="id_anggota" required>
                            <div id="nimError" class="text-danger mt-1"></div>
                        </div>
                        <div class="mb-3">
                            <label for="tahun_jabatan" class="form-label">Tahun Jabatan</label>
                            <input type="number" class="form-control" id="tahun_jabatan" name="tahun_jabatan" required>
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
            const nimField = document.getElementById('id_anggota');
            const nimError = document.getElementById('nimError');
            const submitButton = document.getElementById('submitButton');

            // Fungsi debounce untuk validasi ketika mengetik
            function debounce(func, delay) {
                let timeout;
                return function(...args) {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(this, args), delay);
                };
            }

            // Validasi NIM saat mengetik
            nimField.addEventListener(
                'input',
                debounce(function() {
                    const nimValue = nimField.value.trim();
                    nimError.textContent = ''; // Reset pesan error
                    nimField.classList.remove('is-invalid');
                    submitButton.disabled = true; // Disable tombol submit secara default

                    // Validasi panjang NIM
                    if (nimValue.length !== 9 || isNaN(nimValue)) {
                        nimError.textContent = 'NIM harus berupa 9 digit angka.';
                        nimField.classList.add('is-invalid');
                        return;
                    }

                    // Validasi prefix kode prodi
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

                    // Jika valid, enable tombol submit
                    nimField.classList.remove('is-invalid');
                    submitButton.disabled = false;
                }, 500)
            );
        });

        // Validasi Tahun Jabatan
        document.addEventListener('DOMContentLoaded', function() {
            const tahunField = document.getElementById('tahun_jabatan');
            const tahunError = document.getElementById('tahunError');
            const submitButton = document.getElementById('submitButton');

            function validateYearLength(input) {
                const value = input.value.trim();

                tahunError.textContent = ''; // Reset pesan error
                if (value.length !== 4 || value < 1900 || value > new Date().getFullYear()) {
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

        // Validasi NIM di modal edit
        function validateNIM(input, id) {
            const nimError = document.getElementById(`nimError-${id}`);
            const submitButton = document.getElementById(`submitButton-${id}`);
            const nimValue = input.value.trim();

            nimError.textContent = ''; // Reset error
            submitButton.disabled = true;

            // Validasi panjang dan format NIM
            if (!/^\d{9}$/.test(nimValue)) {
                nimError.textContent = 'NIM harus berupa 9 digit angka.';
                input.classList.add('is-invalid');
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
                nimError.textContent = 'NIM tidak sesuai dengan kode prodi yang valid.';
                input.classList.add('is-invalid');
                return;
            }

            // Jika format valid, enable tombol submit
            input.classList.remove('is-invalid');
            submitButton.disabled = false;
        }
    </script>







@endsection
