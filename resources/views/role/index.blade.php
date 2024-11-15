@extends('layouts.user_type.auth')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Pengaturan Role User</h5>
                        </div>
                        <!-- Tombol Tambah User yang membuka modal -->
                        <a href="#" class="btn bg-gradient-primary btn-sm mb-0" data-bs-toggle="modal"
                            data-bs-target="#createUserModal">
                            +&nbsp; Tambah User
                        </a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center"
                                        style="width: 100px;">Actions</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">ID
                                        Anggota</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Nama</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Email</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Role Saat Ini</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($anggota as $user)
                                    <tr>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center align-items-center gap-2">
                                                <!-- Edit Role Button -->
                                                <a href="#" class="btn btn-link p-0 m-0" data-bs-toggle="modal"
                                                    data-bs-target="#editRoleModal-{{ $user->id_anggota }}">
                                                    <i class="fas fa-user-edit text-secondary"></i>
                                                </a>
                                                <!-- Delete User Button -->
                                                <form action="{{ route('role.delete', $user->id_anggota) }}" method="POST"
                                                    class="d-inline-block d-flex align-items-center m-0 p-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link p-0 m-0"
                                                        onclick="return confirm('Apakah Anda yakin ingin mereset role user ini ke Anggota?')">
                                                        <i class="fas fa-trash text-secondary"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $user->id_anggota }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $user->nama_anggota }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $user->email }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $user->role_name }}</p>
                                        </td>
                                    </tr>

                                    <!-- Modal Edit Role -->
                                    <div class="modal fade" id="editRoleModal-{{ $user->id_anggota }}" tabindex="-1"
                                        aria-labelledby="editRoleModalLabel-{{ $user->id_anggota }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form action="{{ route('role.update', $user->id_anggota) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="editRoleModalLabel-{{ $user->id_anggota }}">Edit Role User
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="role">Pilih Role</label>
                                                            <select name="id_role" id="role" class="form-select"
                                                                required>
                                                                @foreach ($roles as $role)
                                                                    <option value="{{ $role->id }}"
                                                                        {{ $role->name === $user->role_name ? 'selected' : '' }}>
                                                                        {{ $role->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
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

    <!-- Success Message -->
    @if (session('success'))
        <div class="alert alert-success mt-2 mx-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Menampilkan pesan error di form -->
    @if ($errors->any())
        <div class="alert alert-danger mt-2 mx-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Modal for Creating New User -->
    <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('role.create') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createUserModalLabel">Tambah Role untuk Anggota</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Input NIM dengan Validasi AJAX -->
                        <div class="mb-3">
                            <label for="id_anggota" class="form-label">NIM</label>
                            <input type="text" class="form-control" id="id_anggota" name="id_anggota" required>
                            <div id="nimError" class="text-danger mt-1"></div>
                        </div>

                        <!-- Dropdown untuk Role -->
                        <div class="mb-3">
                            <label for="id_role" class="form-label">Role</label>
                            <select name="id_role" id="id_role" class="form-select" required>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="submitButton">Simpan</button>
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
