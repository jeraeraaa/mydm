@extends('layouts.app')

@section('content')
    <div class="font-[sans-serif] bg-white w-full min-h-screen flex items-center justify-center p-0 m-0">
        <div class="items-center w-full h-full max-w-screen-xl mx-auto pt-100">
            <!-- Bagian Form -->
            <form method="POST" action="{{ route('register') }}"
                class="w-full flex flex-col justify-center px-12 py-16 bg-white h-full" enctype="multipart/form-data">
                @csrf

                <div class="mb-8">
                    <h3 class="text-gray-800 text-3xl font-bold">Create an account</h3>
                </div>

                <div class="space-y-6">
                    <!-- NIM Field -->
                    <div>
                        <label class="text-gray-800 text-sm mb-2 block">NIM</label>
                        <input id="id_anggota" name="id_anggota" type="text" required
                            class="text-gray-800 bg-white border border-gray-300 w-full text-sm px-4 py-2.5 rounded-md"
                            placeholder="Enter NIM" value="{{ old('id_anggota') }}" />
                        <div id="nimError" class="text-red-500 text-sm"></div>
                        @error('id_anggota')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Nama Field -->
                    <div>
                        <label class="text-gray-800 text-sm mb-2 block">Nama Lengkap</label>
                        <input id="nama_anggota" name="nama_anggota" type="text" required
                            class="text-gray-800 bg-white border border-gray-300 w-full text-sm px-4 py-2.5 rounded-md"
                            placeholder="Enter full name" value="{{ old('nama_anggota') }}" />
                        <div id="namaError" class="text-red-500 text-sm"></div>
                        @error('nama_anggota')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label class="text-gray-800 text-sm mb-2 block">Email</label>
                        <input id="email" name="email" type="email" required
                            class="text-gray-800 bg-white border border-gray-300 w-full text-sm px-4 py-2.5 rounded-md"
                            placeholder="Enter email" value="{{ old('email') }}" />
                        <div id="emailError" class="text-red-500 text-sm"></div>
                        @error('email')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label class="text-gray-800 text-sm mb-2 block">Password</label>
                        <input name="password" type="password" required
                            class="text-gray-800 bg-white border border-gray-300 w-full text-sm px-4 py-2.5 rounded-md"
                            placeholder="Enter password" />
                        <div id="passwordError" class="text-red-500 text-sm"></div>
                        @error('password')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Confirm Password Field -->
                    <div>
                        <label class="text-gray-800 text-sm mb-2 block">Confirm Password</label>
                        <input name="password_confirmation" type="password" required
                            class="text-gray-800 bg-white border border-gray-300 w-full text-sm px-4 py-2.5 rounded-md"
                            placeholder="Confirm password" />
                        <div id="confirmPasswordError" class="text-red-500 text-sm"></div>
                    </div>

                    <!-- No HP Field -->
                    <div>
                        <label class="text-gray-800 text-sm mb-2 block">Nomor HP</label>
                        <input id="no_hp" name="no_hp" type="text" required
                            class="text-gray-800 bg-white border border-gray-300 w-full text-sm px-4 py-2.5 rounded-md"
                            placeholder="Enter phone number" value="{{ old('no_hp') }}" />
                        <div id="noHpError" class="text-red-500 text-sm"></div>
                        @error('no_hp')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Tanggal Lahir Field -->
                    <div>
                        <label class="text-gray-800 text-sm mb-2 block">Tanggal Lahir</label>
                        <input id="tanggal_lahir" name="tanggal_lahir" type="date" required
                            class="text-gray-800 bg-white border border-gray-300 w-full text-sm px-4 py-2.5 rounded-md"
                            value="{{ old('tanggal_lahir') }}" />
                        <div id="tanggalLahirError" class="text-red-500 text-sm"></div>
                        @error('tanggal_lahir')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Jenis Kelamin Field -->
                    <div>
                        <label class="text-gray-800 text-sm mb-2 block">Jenis Kelamin</label>
                        <select name="jenis_kelamin" required
                            class="text-gray-800 bg-white border border-gray-300 w-full text-sm px-4 py-2.5 rounded-md">
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Alamat Field -->
                    <div>
                        <label class="text-gray-800 text-sm mb-2 block">Alamat</label>
                        <textarea name="alamat" required
                            class="text-gray-800 bg-white border border-gray-300 w-full text-sm px-4 py-2.5 rounded-md"
                            placeholder="Enter address">{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Foto Profil Field -->
                    <div>
                        <label class="text-gray-800 text-sm mb-2 block">Foto Profil (Optional)</label>
                        <input name="foto_profil" type="file"
                            class="text-gray-800 bg-white border border-gray-300 w-full text-sm px-4 py-2.5 rounded-md"
                            accept="image/*" />
                        @error('foto_profil')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-12">
                    <button type="submit"
                        class="w-full py-3 px-4 tracking-wider text-sm rounded-md text-white bg-orange-500 hover:bg-orange-800 focus:outline-none">
                        Create an account
                    </button>
                </div>

                <!-- Pesan Sukses atau Error -->
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                        role="alert">
                        <strong class="font-bold">Success!</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @elseif(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Error!</strong>
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                <p class="text-gray-800 text-sm mt-6 text-center">Already have an account? <a href="{{ route('login') }}"
                        class="text-orange-500 font-semibold hover:underline ml-1">Login here</a></p>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mendapatkan elemen input dan elemen error
            const nimField = document.getElementById('id_anggota');
            const nimError = document.getElementById('nimError');
            const namaField = document.getElementById('nama_anggota');
            const namaError = document.getElementById('namaError');
            const emailField = document.getElementById('email');
            const emailError = document.getElementById('emailError');
            const passwordField = document.querySelector('input[name="password"]');
            const confirmPasswordField = document.querySelector('input[name="password_confirmation"]');
            const passwordError = document.getElementById('passwordError');
            const confirmPasswordError = document.getElementById('confirmPasswordError');
            const noHpField = document.getElementById('no_hp');
            const noHpError = document.getElementById('noHpError');
            const tanggalLahirField = document.getElementById('tanggal_lahir');
            const tanggalLahirError = document.getElementById('tanggalLahirError');

            // Fungsi debounce untuk menunda pemanggilan fungsi
            function debounce(func, delay = 500) {
                let timeout;
                return function(...args) {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(this, args), delay);
                };
            }

            // Validasi NIM
            nimField.addEventListener('input', debounce(function() {
                const nimValue = nimField.value;
                nimError.textContent = '';

                if (nimValue.length !== 9 || isNaN(nimValue)) {
                    nimError.textContent = 'NIM harus berupa 9 digit angka.';
                    nimField.classList.add('is-invalid');
                } else if (!validateProdiCode(nimValue.substring(0, 3))) {
                    nimError.textContent = 'NIM tidak sesuai dengan kode prodi yang valid.';
                    nimField.classList.add('is-invalid');
                } else {
                    nimField.classList.remove('is-invalid');
                    checkNimExists(nimValue);
                }
            }));

            function validateProdiCode(kodeProdi) {
                const validProdi = ['115', '125', '205', '315', '325', '345', '405', '515', '525', '535', '545',
                    '615', '625', '705', '825', '915'
                ];
                return validProdi.includes(kodeProdi);
            }

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
                    .catch(error => console.error('Error:', error));
            }

            // Validasi Nama
            namaField.addEventListener('input', function() {
                const regex = /^[A-Za-z\s]*$/;
                if (!regex.test(namaField.value)) {
                    namaError.textContent = "Nama hanya boleh berisi huruf dan spasi.";
                    namaField.classList.add('is-invalid');
                } else {
                    namaError.textContent = "";
                    namaField.classList.remove('is-invalid');
                }
            });

            // Validasi Email
            emailField.addEventListener('input', debounce(function() {
                const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                emailError.textContent = '';

                if (!emailPattern.test(emailField.value)) {
                    emailError.textContent = 'Format email tidak valid.';
                    emailField.classList.add('is-invalid');
                } else {
                    emailField.classList.remove('is-invalid');
                    checkEmailExists(emailField.value);
                }
            }));

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
                    .catch(error => console.error('Error:', error));
            }

            // Validasi Password
            passwordField.addEventListener('input', function() {
                const password = passwordField.value;
                let errorMessage = '';

                if (password.length < 8) {
                    errorMessage = "Password minimal 8 karakter.";
                } else if (!/[A-Z]/.test(password)) {
                    errorMessage = "Password harus mengandung setidaknya satu huruf besar.";
                } else if (!/[a-z]/.test(password)) {
                    errorMessage = "Password harus mengandung setidaknya satu huruf kecil.";
                } else if (!/[0-9]/.test(password)) {
                    errorMessage = "Password harus mengandung setidaknya satu angka.";
                } else if (!/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
                    errorMessage = "Password harus mengandung setidaknya satu karakter khusus.";
                }

                passwordError.textContent = errorMessage;
                passwordField.classList.toggle('is-invalid', errorMessage !== '');
            });

            // Validasi Konfirmasi Password
            confirmPasswordField.addEventListener('input', function() {
                if (passwordField.value !== confirmPasswordField.value) {
                    confirmPasswordError.textContent = "Password tidak cocok.";
                    confirmPasswordField.classList.add('is-invalid');
                } else {
                    confirmPasswordError.textContent = '';
                    confirmPasswordField.classList.remove('is-invalid');
                }
            });

            // Validasi Nomor HP
            noHpField.addEventListener('input', function() {
                if (!/^\d{10,13}$/.test(noHpField.value)) {
                    noHpError.textContent = 'Nomor HP harus terdiri dari 10-13 digit angka.';
                    noHpField.classList.add('is-invalid');
                } else {
                    noHpError.textContent = '';
                    noHpField.classList.remove('is-invalid');
                }
            });

            // Validasi Tanggal Lahir
            tanggalLahirField.addEventListener('change', function() {
                const tanggalLahirValue = new Date(tanggalLahirField.value);
                const today = new Date();
                const age = today.getFullYear() - tanggalLahirValue.getFullYear();

                if (age < 17) {
                    tanggalLahirError.textContent = 'Anggota harus berusia minimal 17 tahun.';
                    tanggalLahirField.classList.add('is-invalid');
                } else {
                    tanggalLahirError.textContent = '';
                    tanggalLahirField.classList.remove('is-invalid');
                }
            });

            // Cegah submit form jika ada kesalahan
            document.querySelector('form').addEventListener('submit', function(event) {
                if (passwordError.textContent || confirmPasswordError.textContent || nimError.textContent ||
                    emailError.textContent || namaError.textContent || noHpError.textContent ||
                    tanggalLahirError.textContent) {
                    event.preventDefault();
                    alert("Periksa kembali data yang Anda masukkan.");
                }
            });
        });
    </script>
@endsection
