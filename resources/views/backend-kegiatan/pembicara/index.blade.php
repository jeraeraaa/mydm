@extends('layouts.user_type.auth')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">All Speakers</h5>
                        </div>
                        <!-- Add Speaker Button that opens the modal -->
                        <a href="#" class="btn bg-gradient-primary btn-sm mb-0" data-bs-toggle="modal"
                            data-bs-target="#createSpeakerModal">
                            +&nbsp; Add Speaker
                        </a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center"
                                        style="width: 120px;">
                                        Actions
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Speaker Name
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Contact
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pembicara as $speaker)
                                    <tr>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center align-items-center gap-2">
                                                <!-- Edit Speaker -->
                                                <a href="{{ route('pembicara.edit', $speaker->id_pembicara) }}"
                                                    class="btn btn-link p-0 m-0">
                                                    <i class="fas fa-edit text-secondary"></i>
                                                </a>

                                                <!-- Delete Speaker -->
                                                <form action="{{ route('pembicara.destroy', $speaker->id_pembicara) }}"
                                                    method="POST" class="d-inline-block d-flex align-items-center m-0 p-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link p-0 m-0"
                                                        onclick="return confirm('Are you sure you want to delete this speaker?')">
                                                        <i class="fas fa-trash text-secondary"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $speaker->nama_pembicara }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $speaker->kontak_pembicara }}</p>
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

    <!-- Success Message -->
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

    <!-- Modal for Creating New Speaker -->
    <div class="modal fade" id="createSpeakerModal" tabindex="-1" role="dialog" aria-labelledby="createSpeakerModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createSpeakerModalLabel">Add New Speaker</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Speaker Creation Form with Validation -->
                    <form action="{{ route('pembicara.store') }}" method="POST" id="createSpeakerForm">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_pembicara" class="form-label">Speaker Name</label>
                            <input type="text" class="form-control" id="nama_pembicara" name="nama_pembicara" required>
                            <div id="nameError" class="text-danger mt-1"></div>
                        </div>
                        <div class="mb-3">
                            <label for="kontak_pembicara" class="form-label">Contact (Phone Number)</label>
                            <input type="text" class="form-control" id="kontak_pembicara" name="kontak_pembicara"
                                required>
                            <div id="contactError" class="text-danger mt-1"></div>
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
                    nameError.textContent = "Nama Pembicara hanya boleh mengandung huruf dan spasi.";
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
                        "Kontak Pembicara harus berupa angka dan memiliki panjang antara 10-15 digit.";
                    contactField.classList.add('is-invalid');
                } else {
                    contactError.textContent = "";
                    contactField.classList.remove('is-invalid');
                }
            });

            // Prevent form submission if fields are invalid
            document.getElementById('createSpeakerForm').addEventListener('submit', function(event) {
                if (nameField.classList.contains('is-invalid') || contactField.classList.contains(
                        'is-invalid')) {
                    event.preventDefault();
                }
            });
        });
    </script>
@endsection
