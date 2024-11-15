@extends('layouts.user_type.auth')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4 mx-4">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h5 class="mb-0">Pengaturan Role User</h5>
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
                                    <button class="btn btn-sm bg-gradient-primary" data-bs-toggle="modal" data-bs-target="#editRoleModal-{{ $user->id_anggota }}">
                                        Edit Role
                                    </button>
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

@endsection