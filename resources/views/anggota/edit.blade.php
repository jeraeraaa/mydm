@extends('layouts.user_type.auth')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Edit Anggota</h5>
                </div>
                <div class="card-body px-4 pt-4 pb-2">
                    <form action="{{ route('anggota.update', $anggota->id_anggota) }}" method="POST"
                        enctype="multipart/form-data" id="editForm">
                        @csrf
                        @method('PUT')

                        <!-- NIM -->
                        <div class="mb-3">
                            <label for="id_anggota" class="form-label">NIM</label>
                            <input type="text" class="form-control" id="id_anggota" name="id_anggota"
                                value="{{ $anggota->id_anggota }}" required>
                            <div id="nimError" class="text-danger mt-1"></div>
                        </div>

                        <!-- Nama Lengkap -->
                        <div class="mb-3">
                            <label for="nama_anggota" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama_anggota" name="nama_anggota"
                                value="{{ $anggota->nama_anggota }}" required>
                            <div id="namaError" class="text-danger mt-1"></div>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ $anggota->email }}" required>
                            <div id="emailError" class="text-danger mt-1"></div>
                        </div>

                        <!-- Nomor HP -->
                        <div class="mb-3">
                            <label for="no_hp" class="form-label">Nomor HP</label>
                            <input type="text" class="form-control" id="no_hp" name="no_hp"
                                value="{{ $anggota->no_hp }}" required>
                            <div id="noHpError" class="text-danger mt-1"></div>
                        </div>

                        <!-- Tanggal Lahir -->
                        <div class="mb-3">
                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                                value="{{ $anggota->tanggal_lahir }}" required>
                            <div id="tanggalLahirError" class="text-danger mt-1"></div>
                        </div>

                        <!-- Jenis Kelamin -->
                        <div class="mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-select" required>
                                <option value="L" {{ $anggota->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki
                                </option>
                                <option value="P" {{ $anggota->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan
                                </option>
                            </select>
                        </div>

                        <!-- Alamat -->
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea name="alamat" id="alamat" class="form-control" rows="3" required>{{ $anggota->alamat }}</textarea>
                        </div>

                        <!-- Foto Profil -->
                        <div class="mb-3">
                            <label for="foto_profil" class="form-label">Foto Profil</label>
                            <input type="file" class="form-control" id="foto_profil" name="foto_profil" accept="image/*">
                            @if ($anggota->foto_profil)
                                <p class="mt-2">Current photo: <img
                                        src="{{ asset('storage/foto_profil/' . $anggota->foto_profil) }}" width="100">
                                </p>
                            @endif
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <a href="{{ route('anggota.index') }}" class="btn btn-secondary me-2"><i
                                    class="fa fa-times"></i> Cancel</a>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nimField = document.getElementById('id_anggota');
            const nimError = document.getElementById('nimError');
            const namaField = document.getElementById('nama_anggota');
            const namaError = document.getElementById('namaError');
            const emailField = document.getElementById('email');
            const emailError = document.getElementById('emailError');

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

                // Validasi panjang NIM
                if (nimValue.length !== 9 || isNaN(nimValue)) {
                    nimError.textContent = 'NIM harus berupa 9 digit angka.';
                    nimField.classList.add('is-invalid');
                    return; // Hentikan fungsi jika tidak valid
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
                    return; // Hentikan fungsi jika tidak valid
                }

                // Periksa apakah NIM sudah ada di database
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
                            nimError.textContent = 'NIM ini sudah terdaftar.';
                            nimField.classList.add('is-invalid');
                        } else {
                            nimError.textContent = '';
                            nimField.classList.remove('is-invalid');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }

            namaField.addEventListener('input', function() {
                // Validasi hanya huruf dan spasi
                const regex = /^[A-Za-z\s]*$/;
                if (!regex.test(namaField.value)) {
                    namaError.textContent = "Nama hanya boleh berisi huruf dan spasi.";
                    namaField.classList.add('is-invalid');
                } else {
                    namaError.textContent = "";
                    namaField.classList.remove('is-invalid');
                }
            });

            // Validasi Email secara langsung saat pengguna mengetik
            emailField.addEventListener('input', debounce(function() {
                const emailValue = emailField.value;
                emailError.textContent = ''; // Reset error

                // Validasi format email
                const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                if (!emailPattern.test(emailValue)) {
                    emailError.textContent = 'Format email tidak valid.';
                    emailField.classList.add('is-invalid');
                    return; // Hentikan fungsi jika format tidak valid
                } else {
                    emailField.classList.remove('is-invalid');
                }

                // Periksa apakah Email sudah ada di database
                checkEmailExists(emailValue);
            }, 500));

            function checkEmailExists(email) {
                fetch(`/check-email?email=${email}`, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.exists) {
                            emailError.textContent = 'Email sudah terdaftar.';
                            emailField.classList.add('is-invalid');
                        } else {
                            emailError.textContent = '';
                            emailField.classList.remove('is-invalid');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }


            // Validasi Nomor HP secara langsung saat pengguna mengetik
            document.getElementById('no_hp').addEventListener('input', function() {
                const noHpField = document.getElementById('no_hp');
                const noHpValue = noHpField.value;
                const noHpError = document.getElementById('noHpError');

                if (!/^\d{10,13}$/.test(noHpValue)) {
                    noHpError.textContent = 'Nomor HP harus terdiri dari 10-13 digit angka.';
                    noHpField.classList.add('is-invalid');
                } else {
                    noHpError.textContent = '';
                    noHpField.classList.remove('is-invalid');
                }
            });

            // Validasi Tanggal Lahir secara langsung saat pengguna memilih tanggal
            document.getElementById('tanggal_lahir').addEventListener('change', function() {
                const tanggalLahirField = document.getElementById('tanggal_lahir');
                const tanggalLahirValue = new Date(tanggalLahirField.value);
                const today = new Date();
                const age = today.getFullYear() - tanggalLahirValue.getFullYear();
                const ageError = document.getElementById('tanggalLahirError');

                if (age < 17) {
                    ageError.textContent = 'Anggota harus berusia minimal 17 tahun.';
                    tanggalLahirField.classList.add('is-invalid');
                } else {
                    ageError.textContent = '';
                    tanggalLahirField.classList.remove('is-invalid');
                }
            });
        });
    </script>
@endsection
