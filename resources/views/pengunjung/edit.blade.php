@extends('layouts.user_type.auth')

@section('content')
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Edit Visitor</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('pengunjung.update', $pengunjung->id_pengunjung) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Visitor Name -->
                        <div class="mb-3">
                            <label for="nama_pengunjung" class="form-label">Visitor Name</label>
                            <input type="text" class="form-control" id="nama_pengunjung" name="nama_pengunjung"
                                value="{{ old('nama_pengunjung', $pengunjung->nama_pengunjung) }}" required>
                        </div>

                        <!-- Phone Number -->
                        <div class="mb-3">
                            <label for="no_hp" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="no_hp" name="no_hp"
                                value="{{ old('no_hp', $pengunjung->no_hp) }}" required>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('pengunjung.index') }}" class="btn btn-secondary">Cancel</a>
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
