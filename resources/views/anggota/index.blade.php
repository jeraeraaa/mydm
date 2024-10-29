@extends('layouts.user_type.auth')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">All Members</h5>
                        </div>
                        <!-- Tombol New Member yang membuka modal -->
                        <a href="#" class="btn bg-gradient-primary btn-sm mb-0" data-bs-toggle="modal"
                            data-bs-target="#createMemberModal">
                            +&nbsp; New Member
                        </a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">NIM</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Photo</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Nama</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Jurusan</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Email</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        No HP</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Tanggal Lahir</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Jenis Kelamin</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Alamat</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($anggota as $item)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->id_anggota }}</p>
                                        </td>
                                        <td>
                                            <div>
                                                <img src="{{ asset('storage/foto_profil/' . $item->foto_profil) }}"
                                                    class="avatar avatar-sm me-3" alt="Photo">
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->nama_anggota }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->prodi->nama_prodi ?? 'N/A' }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->email }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->no_hp }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d/m/Y') }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->alamat }}</p>
                                        </td>
                                        <td class="text-center">
                                            <!-- Edit Member -->
                                            <button class="btn btn-link p-0 m-0" data-bs-toggle="modal"
                                                data-bs-target="#editMemberModal" data-id="{{ $item->id_anggota }}"
                                                data-nama="{{ $item->nama_anggota }}" data-email="{{ $item->email }}"
                                                data-no_hp="{{ $item->no_hp }}"
                                                data-tanggal_lahir="{{ $item->tanggal_lahir }}"
                                                data-jenis_kelamin="{{ $item->jenis_kelamin }}"
                                                data-alamat="{{ $item->alamat }}"
                                                data-foto_profil="{{ $item->foto_profil }}">
                                                <i class="fas fa-user-edit text-secondary"></i>
                                            </button>

                                            <!-- Delete Member -->
                                            <form action="{{ route('anggota.destroy', $item->id_anggota) }}" method="POST"
                                                style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link p-0 m-0"
                                                    onclick="return confirm('Are you sure?')">
                                                    <i class="cursor-pointer fas fa-trash text-secondary"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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


    <!-- Modal for Creating New Member -->
    <div class="modal fade" id="createMemberModal" tabindex="-1" role="dialog" aria-labelledby="createMemberModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createMemberModalLabel">Tambah Anggota Baru</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Formulir tambah anggota -->
                    <form action="{{ route('anggota.store') }}" method="POST" enctype="multipart/form-data"
                        id="anggotaForm">
                        @csrf
                        <div class="mb-3">
                            <label for="id_anggota" class="form-label">NIM</label>
                            <input type="text" class="form-control" id="id_anggota" name="id_anggota"
                                value="{{ old('id_anggota') }}" required>
                            @error('id_anggota')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div id="nimError" class="text-danger mt-1"></div>
                        </div>
                        <div class="mb-3">
                            <label for="nama_anggota" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama_anggota" name="nama_anggota"
                                value="{{ old('nama_anggota') }}" required>
                            @error('nama_anggota')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ old('email') }}" required>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div id="emailError" class="text-danger mt-1"></div>
                        </div>
                        <div class="mb-3">
                            <label for="no_hp" class="form-label">Nomor HP</label>
                            <input type="text" class="form-control" id="no_hp" name="no_hp"
                                value="{{ old('no_hp') }}" required>
                            @error('no_hp')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div id="noHpError" class="text-danger mt-1"></div>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                                value="{{ old('tanggal_lahir') }}" required>
                            @error('tanggal_lahir')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div id="tanggalLahirError" class="text-danger mt-1"></div>
                        </div>
                        <div class="mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-select" required>
                                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki
                                </option>
                                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan
                                </option>
                            </select>
                            @error('jenis_kelamin')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea name="alamat" id="alamat" class="form-control" rows="3" required>{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="foto_profil" class="form-label">Foto Profil</label>
                            <input type="file" class="form-control" id="foto_profil" name="foto_profil"
                                accept="image/*">
                            @error('foto_profil')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
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

    <!-- Modal for Editing Member -->
    <div class="modal fade" id="editMemberModal" tabindex="-1" role="dialog" aria-labelledby="editMemberModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editMemberModalLabel">Edit Anggota</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Formulir edit anggota -->
                    <form action="{{ route('anggota.update', 'id_placeholder') }}" method="POST"
                        enctype="multipart/form-data" id="editAnggotaForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id_anggota" id="edit_id_anggota">
                        <div class="mb-3">
                            <label for="edit_nama_anggota" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="edit_nama_anggota" name="nama_anggota"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit_email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_no_hp" class="form-label">Nomor HP</label>
                            <input type="text" class="form-control" id="edit_no_hp" name="no_hp" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_tanggal_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="edit_tanggal_lahir" name="tanggal_lahir"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="edit_jenis_kelamin" class="form-select" required>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_alamat" class="form-label">Alamat</label>
                            <textarea name="alamat" id="edit_alamat" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_foto_profil" class="form-label">Foto Profil</label>
                            <input type="file" class="form-control" id="edit_foto_profil" name="foto_profil"
                                accept="image/*">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nimField = document.getElementById('id_anggota');
            const emailField = document.getElementById('email');
            const nimError = document.getElementById('nimError');
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




    <script>
        // Memuat data ke dalam modal edit ketika tombol edit ditekan
        document.addEventListener('DOMContentLoaded', function() {
            var editMemberModal = document.getElementById('editMemberModal');
            editMemberModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var id = button.getAttribute('data-id');
                var nama = button.getAttribute('data-nama');
                var email = button.getAttribute('data-email');
                var noHp = button.getAttribute('data-no_hp');
                var tanggalLahir = button.getAttribute('data-tanggal_lahir');
                var jenisKelamin = button.getAttribute('data-jenis_kelamin');
                var alamat = button.getAttribute('data-alamat');
                var foto_profil = button.getAttribute('data-foto_profil');

                var modal = this;
                modal.querySelector('#edit_id_anggota').value = id;
                modal.querySelector('#edit_nama_anggota').value = nama;
                modal.querySelector('#edit_email').value = email;
                modal.querySelector('#edit_no_hp').value = noHp;
                modal.querySelector('#edit_tanggal_lahir').value = tanggalLahir;
                modal.querySelector('#edit_jenis_kelamin').value = jenisKelamin;
                modal.querySelector('#edit_alamat').value = alamat;
                modal.querySelector('#edit_foto_profil').value = foto_profil;

                // Update form action with the correct ID
                modal.querySelector('#editAnggotaForm').action = '{{ route('anggota.update', ':id') }}'
                    .replace(':id', id);
            });
        });
    </script>

@endsection
