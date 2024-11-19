@extends('layouts.user_type.auth')

@section('content')
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Edit External Borrower</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('peminjam-eksternal.update', $borrower->id_peminjam_eksternal) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- NIM (Read-only) -->
                        <div class="mb-3">
                            <label for="id_peminjam_eksternal" class="form-label">NIM</label>
                            <input type="text" class="form-control" id="id_peminjam_eksternal"
                                name="id_peminjam_eksternal" value="{{ $borrower->id_peminjam_eksternal }}" readonly>
                        </div>

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="nama" class="form-label">Name</label>
                            <input type="text" class="form-control" id="nama" name="nama"
                                value="{{ old('nama', $borrower->nama) }}" required>
                        </div>

                        <!-- Organization -->
                        <div class="mb-3">
                            <label for="organisasi" class="form-label">Organization</label>
                            <input type="text" class="form-control" id="organisasi" name="organisasi"
                                value="{{ old('organisasi', $borrower->organisasi) }}" required>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('peminjam-eksternal.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="alert alert-danger mt-3">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Success Message -->
            @if (session('success'))
                <div class="alert alert-success mt-3">
                    {{ session('success') }}
                </div>
            @endif
        </div>
    </div>
@endsection
