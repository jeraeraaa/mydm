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
                                                        <div class="mb-3">
                                                            <label for="id_anggota-{{ $ketum->id_ketum }}"
                                                                class="form-label">ID Anggota</label>
                                                            <select name="id_anggota"
                                                                id="id_anggota-{{ $ketum->id_ketum }}" class="form-select"
                                                                required>
                                                                @foreach ($anggota as $member)
                                                                    <option value="{{ $member->id_anggota }}"
                                                                        {{ $member->id_anggota == $ketum->id_anggota ? 'selected' : '' }}>
                                                                        {{ $member->nama }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
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
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
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

            // Fungsi debounce untuk menunda pemanggilan fungsi
            function debounce(func, delay) {
                let timeout;
                return function(...args) {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(this, args), delay);
                };
            }

            // Validasi NIM secara langsung saat pengguna mengetik
            nimField.addEventListener('input', debounce(function() {
                const nimValue = nimField.value;
                nimError.textContent = ''; // Reset error
                submitButton.disabled = true; // Disable submit button by default

                // Validasi panjang NIM
                if (nimValue.length !== 9 || isNaN(nimValue)) {
                    nimError.textContent = 'NIM harus berupa 9 digit angka.';
                    nimField.classList.add('is-invalid');
                    return;
                } else {
                    nimField.classList.remove('is-invalid');
                }

                // Validasi kode prodi dari NIM
                const kodeProdi = nimValue.substring(0, 3);
                const validProdi = [
                    '115', '125', '205', '315', '325', '345', '405', '515',
                    '525', '535', '545', '615', '625', '705', '825', '915'
                ];
                if (!validProdi.includes(kodeProdi)) {
                    nimError.textContent = 'NIM tidak sesuai dengan kode prodi yang valid.';
                    nimField.classList.add('is-invalid');
                    return;
                }

                // Panggil fungsi untuk memeriksa apakah NIM sudah ada di database
                checkNimExists(nimValue);
            }, 500));

            function checkNimExists(nim) {
                fetch(`/check-nim?nim=${nim}`, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.exists) {
                            nimError.textContent = 'NIM ini sudah terdaftar atau sudah memiliki role tertentu.';
                            nimField.classList.add('is-invalid');
                            submitButton.disabled = true; // Disable submit if NIM exists
                        } else {
                            nimError.textContent = '';
                            nimField.classList.remove('is-invalid');
                            submitButton.disabled = false; // Enable submit if NIM is valid
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        nimError.textContent = 'Terjadi kesalahan saat memvalidasi NIM.';
                        submitButton.disabled = true;
                    });
            }
        });
    </script>
@endsection
