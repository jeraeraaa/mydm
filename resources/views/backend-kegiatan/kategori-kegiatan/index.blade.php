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
                    <a href="#" class="btn bg-gradient-primary btn-sm mb-0" data-bs-toggle="modal" data-bs-target="#createUserModal">
                        +&nbsp; Tambah User
                    </a>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID Anggota</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Email</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Role Saat Ini</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($anggota as $user)
                            <tr>
                                <td>{{ $user->id_anggota }}</td>
                                <td>{{ $user->nama_anggota }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role_name }}</td>
                                <td class="text-center">
                                    <!-- Edit Role Button -->
                                    <a href="#" class="btn btn-link p-0 m-0" data-bs-toggle="modal" data-bs-target="#editRoleModal-{{ $user->id_anggota }}">
                                        <i class="fas fa-edit text-secondary"></i>
                                    </a>
                                    <!-- Delete User Button -->
                                    <form action="{{ route('role.delete', $user->id_anggota) }}" method="POST" class="d-inline-block d-flex align-items-center m-0 p-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link p-0 m-0" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                            <i class="fas fa-trash text-secondary"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Modal Edit Role -->
                            <div class="modal fade" id="editRoleModal-{{ $user->id_anggota }}" tabindex="-1" aria-labelledby="editRoleModalLabel-{{ $user->id_anggota }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('role.update', $user->id_anggota) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editRoleModalLabel-{{ $user->id_anggota }}">Edit Role User</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="role">Pilih Role</label>
                                                    <select name="id_role" id="role" class="form-select" required>
                                                        @foreach ($roles as $role)
                                                        <option value="{{ $role->id }}" {{ $role->name === $user->role_name ? 'selected' : '' }}>
                                                            {{ $role->name }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
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

<!-- Modal for Creating New User -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('role.create') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createUserModalLabel">Tambah User Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="id_anggota" class="form-label">ID Anggota</label>
                        <input type="text" class="form-control" id="id_anggota" name="id_anggota" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama_anggota" class="form-label">Nama Anggota</label>
                        <input type="text" class="form-control" id="nama_anggota" name="nama_anggota" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
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
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
