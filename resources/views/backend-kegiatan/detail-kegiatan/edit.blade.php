@extends('layouts.user_type.auth')

@section('content')
    <!-- Content -->
    <div class="col-12">
        <div class="card mb-4 mx-4">
            <div class="card-header pb-0">
                <h5 class="mb-0">Edit Detail Kegiatan</h5>
            </div>
            <div class="card-body">
                <form id="detailKegiatanForm"
                    action="{{ route('detail-kegiatan.update', $detailKegiatan->id_detail_kegiatan) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nama_detail_kegiatan" class="form-label">Nama Detail Kegiatan</label>
                        <input type="text" class="form-control" id="nama_detail_kegiatan" name="nama_detail_kegiatan"
                            value="{{ old('nama_detail_kegiatan', $detailKegiatan->nama_detail_kegiatan) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi_detail" class="form-label">Deskripsi Detail Kegiatan</label>
                        <textarea class="form-control" id="deskripsi_detail" name="deskripsi_detail" rows="3" required>{{ old('deskripsi_detail', $detailKegiatan->deskripsi_detail) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="id_kegiatan" class="form-label">Kegiatan</label>
                        <select name="id_kegiatan" id="id_kegiatan" class="form-select" required>
                            <option value="">Pilih Kegiatan</option>
                            @foreach ($kegiatanList as $kegiatan)
                                <option value="{{ $kegiatan->id_kegiatan }}"
                                    {{ $detailKegiatan->id_kegiatan == $kegiatan->id_kegiatan ? 'selected' : '' }}>
                                    {{ $kegiatan->nama_kegiatan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="id_bph" class="form-label">Divisi BPH</label>
                        <select name="id_bph" id="id_bph" class="form-select">
                            <option value="">Pilih Divisi</option>
                            @foreach ($bphList as $division)
                                <option value="{{ $division->id_bph }}"
                                    {{ $detailKegiatan->id_bph == $division->id_bph ? 'selected' : '' }}>
                                    {{ $division->nama_divisi_bph }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai"
                            value="{{ old('tanggal_mulai', $detailKegiatan->tanggal_mulai) }}">
                    </div>

                    <div class="mb-3">
                        <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                        <input type="time" class="form-control" id="waktu_mulai" name="waktu_mulai"
                            value="{{ old('waktu_mulai', $detailKegiatan->waktu_mulai) }}">
                    </div>


                    <div class="mb-3">
                        <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                        <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai"
                            value="{{ old('tanggal_selesai', $detailKegiatan->tanggal_selesai) }}">
                        <div id="tanggalError" class="text-danger mt-1" style="display: none;">
                            Tanggal selesai tidak boleh lebih awal dari tanggal mulai.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="waktu_selesai" class="form-label">Waktu Selesai</label>
                        <input type="time" class="form-control" id="waktu_selesai" name="waktu_selesai"
                            value="{{ old('waktu_selesai', $detailKegiatan->waktu_selesai) }}">
                        <div id="waktuError" class="text-danger mt-1" style="display: none;">
                            Waktu selesai tidak boleh lebih awal dari waktu mulai jika tanggalnya sama.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="lokasi" class="form-label">Lokasi</label>
                        <input type="text" class="form-control" id="lokasi" name="lokasi"
                            value="{{ old('lokasi', $detailKegiatan->lokasi) }}">
                    </div>

                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto Kegiatan</label>
                        <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                        <div id="fotoError" class="text-danger mt-1"></div>
                        @if ($detailKegiatan->foto)
                            <p>Foto saat ini:</p>
                            <img src="{{ asset('storage/' . $detailKegiatan->foto) }}" alt="Foto Kegiatan"
                                style="width: 150px; height: auto;">
                        @endif
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <a href="{{ route('detail-kegiatan.index') }}" class="btn btn-secondary me-2"><i
                                class="fa fa-times"></i>
                            Cancel</a>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Changes</button>
                    </div>
                </form>
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

    <!-- Script untuk memvalidasi tanggal dan waktu -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tanggalMulai = document.getElementById('tanggal_mulai');
            const tanggalSelesai = document.getElementById('tanggal_selesai');
            const waktuMulai = document.getElementById('waktu_mulai');
            const waktuSelesai = document.getElementById('waktu_selesai');
            const tanggalError = document.getElementById('tanggalError');
            const waktuError = document.getElementById('waktuError');

            function validateTanggalWaktu() {
                let startDate = new Date(tanggalMulai.value);
                let endDate = new Date(tanggalSelesai.value);
                let startTime = waktuMulai.value;
                let endTime = waktuSelesai.value;

                // Validasi Tanggal
                if (tanggalMulai.value && tanggalSelesai.value && endDate < startDate) {
                    tanggalError.style.display = 'block';
                    tanggalSelesai.classList.add('is-invalid');
                } else {
                    tanggalError.style.display = 'none';
                    tanggalSelesai.classList.remove('is-invalid');
                }

                // Validasi Waktu jika tanggal mulai dan selesai sama
                if (tanggalMulai.value && tanggalSelesai.value && startDate.getTime() === endDate.getTime()) {
                    if (startTime && endTime && endTime <= startTime) {
                        waktuError.style.display = 'block';
                        waktuSelesai.classList.add('is-invalid');
                    } else {
                        waktuError.style.display = 'none';
                        waktuSelesai.classList.remove('is-invalid');
                    }
                } else {
                    waktuError.style.display = 'none';
                    waktuSelesai.classList.remove('is-invalid');
                }
            }

            tanggalMulai.addEventListener('change', validateTanggalWaktu);
            tanggalSelesai.addEventListener('change', validateTanggalWaktu);
            waktuMulai.addEventListener('change', validateTanggalWaktu);
            waktuSelesai.addEventListener('change', validateTanggalWaktu);
        });
    </script>
@endsection
