@extends('layouts.user_type.auth')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Edit Speaker</h5>
                </div>
                <div class="card-body px-4 pt-4 pb-2">
                    <form action="{{ route('pembicara.update', $pembicara->id_pembicara) }}" method="POST"
                        id="editSpeakerForm">
                        @csrf
                        @method('PUT')

                        <!-- Nama Pembicara -->
                        <div class="mb-3">
                            <label for="nama_pembicara" class="form-label">Speaker Name</label>
                            <input type="text" class="form-control" id="nama_pembicara" name="nama_pembicara"
                                value="{{ $pembicara->nama_pembicara }}" required>
                            <div id="nameError" class="text-danger mt-1"></div>
                        </div>

                        <!-- Kontak Pembicara -->
                        <div class="mb-3">
                            <label for="kontak_pembicara" class="form-label">Contact (Phone Number)</label>
                            <input type="text" class="form-control" id="kontak_pembicara" name="kontak_pembicara"
                                value="{{ $pembicara->kontak_pembicara }}" required>
                            <div id="contactError" class="text-danger mt-1"></div>
                        </div>

                        <!-- Tombol Simpan dan Batal -->
                        <div class="d-flex justify-content-end mt-3">
                            <a href="{{ route('pembicara.index') }}" class="btn btn-secondary me-2"><i
                                    class="fa fa-times"></i> Cancel</a>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Changes</button>
                        </div>
                    </form>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nameField = document.getElementById('nama_pembicara');
            const contactField = document.getElementById('kontak_pembicara');
            const nameError = document.getElementById('nameError');
            const contactError = document.getElementById('contactError');

            // Name Validation: Only letters and spaces
            nameField.addEventListener('input', function() {
                const regex = /^[A-Za-z\s]+$/;
                if (!regex.test(nameField.value)) {
                    nameError.textContent = "Nama Pembicara hanya boleh berisi huruf dan spasi.";
                    nameField.classList.add('is-invalid');
                } else {
                    nameError.textContent = "";
                    nameField.classList.remove('is-invalid');
                }
            });

            // Contact Validation: Only numbers, between 10 to 15 digits
            contactField.addEventListener('input', function() {
                const regex = /^\d{10,15}$/;
                if (!regex.test(contactField.value)) {
                    contactError.textContent =
                        "Kontak Pembicara hanya boleh berisi angka dan harus antara 10-15 digit.";
                    contactField.classList.add('is-invalid');
                } else {
                    contactError.textContent = "";
                    contactField.classList.remove('is-invalid');
                }
            });

            // Prevent form submission if fields are invalid
            document.getElementById('editSpeakerForm').addEventListener('submit', function(event) {
                if (nameField.classList.contains('is-invalid') || contactField.classList.contains(
                        'is-invalid')) {
                    event.preventDefault();
                }
            });
        });
    </script>
@endsection
