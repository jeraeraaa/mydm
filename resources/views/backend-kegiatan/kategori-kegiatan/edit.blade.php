@extends('layouts.user_type.auth')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Edit Kategori Kegiatan</h5>
                </div>
                <div class="card-body px-4 pt-4 pb-2">
                    <form action="{{ route('kategori-kegiatan.update', $kategori->id_kategori_kegiatan) }}" method="POST"
                        id="editCategoryForm">
                        @csrf
                        @method('PUT')

                        <!-- Nama Kategori -->
                        <div class="mb-3">
                            <label for="nama_kategori" class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control" id="nama_kategori" name="nama_kategori"
                                value="{{ $kategori->nama_kategori }}" required>
                            <div id="namaKategoriError" class="text-danger mt-1"></div>
                        </div>

                        <!-- Tombol Simpan dan Batal -->
                        <div class="d-flex justify-content-end mt-3">
                            <a href="{{ route('kategori-kegiatan.index') }}" class="btn btn-secondary me-2"><i
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
            const namaKategoriField = document.getElementById('nama_kategori');
            const namaKategoriError = document.getElementById('namaKategoriError');

            // Validasi Nama Kategori secara langsung
            namaKategoriField.addEventListener('input', function() {
                const kategoriValue = namaKategoriField.value.trim();
                if (kategoriValue.length === 0) {
                    namaKategoriError.textContent = "Nama kategori tidak boleh kosong.";
                    namaKategoriField.classList.add('is-invalid');
                } else {
                    namaKategoriError.textContent = "";
                    namaKategoriField.classList.remove('is-invalid');
                }
            });
        });
    </script>
@endsection
