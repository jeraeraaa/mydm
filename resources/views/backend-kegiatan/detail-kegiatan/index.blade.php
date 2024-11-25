@extends('layouts.user_type.auth')

@section('content')
    <div class="col-12">
        <div class="card mb-4 mx-4">
            <div class="card-header pb-0">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <h5 class="mb-0">All Activity Details</h5>
                        <p class="text-sm">Daftar semua detail kegiatan yang tersedia</p>
                    </div>

                    <div class="text-right">
                        <a href="{{ route('detail-kegiatan.laporan') }}" class="btn bg-gradient-info btn-sm mb-0">
                            <i class="fas fa-file-alt me-2"></i> Laporan Detail Kegiatan
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach ($details as $detail)
                        <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">
                            <div class="card card-blog card-plain">
                                <div class="position-relative">
                                    <a class="d-block shadow-xl border-radius-xl">
                                        <img src="{{ $detail->foto ? url('storage/' . $detail->foto) : asset('assets/img/defaultbarang.jpg') }}"
                                            alt="Activity Photo" class="img-fluid shadow border-radius-xl"
                                            style="width: 100%; height: 250px; object-fit: cover;">
                                    </a>
                                </div>
                                <div class="card-body px-1 pb-0">
                                    <a href="javascript:;">
                                        <h5>
                                            {{ $detail->nama_detail_kegiatan }}
                                        </h5>
                                    </a>
                                    <p class="mb-3 text-sm">
                                        <strong>Deskripsi:</strong> {{ $detail->deskripsi_detail ?? 'Tidak ada Deskripsi' }}
                                    </p>
                                    <p class="mb-3 text-sm">
                                        <strong>Lokasi:</strong> {{ $detail->lokasi }}
                                    </p>
                                    <p class="mb-3 text-sm">
                                        <strong>Tanggal Mulai:</strong>
                                        {{ $detail->tanggal_mulai ? \Carbon\Carbon::parse($detail->tanggal_mulai)->format('d/m/Y') : '-' }}
                                    </p>
                                    <p class="mb-3 text-sm">
                                        <strong>Waktu Mulai:</strong>
                                        {{ $detail->waktu_mulai ? \Carbon\Carbon::parse($detail->waktu_mulai)->format('H:i') : '-' }}
                                    </p>
                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                        <a href="{{ route('detail-kegiatan.show', $detail->id_detail_kegiatan) }}"
                                            class="btn btn-outline-primary btn-sm mb-0">Details</a>
                                        <div class="d-flex justify-content-right align-items-center gap-2">
                                            <!-- Edit Activity -->
                                            <a href="{{ route('detail-kegiatan.edit', $detail->id_detail_kegiatan) }}"
                                                class="btn btn-link p-0 m-0">
                                                <i class="fas fa-edit text-secondary fa-2x"></i>
                                            </a>
                                            <!-- Delete Activity -->
                                            <form
                                                action="{{ route('detail-kegiatan.destroy', $detail->id_detail_kegiatan) }}"
                                                method="POST" class="d-inline-block d-flex align-items-center m-0 p-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link p-0 m-0"
                                                    onclick="return confirm('Are you sure?')">
                                                    <i class="fas fa-trash text-secondary fa-2x"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">
                        <div class="card h-100 card-plain border">
                            <div class="card-body d-flex flex-column justify-content-center text-center">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#createDetailActivityModal">
                                    <i class="fa fa-plus text-secondary mb-3"></i>
                                    <h5 class="text-secondary">Tambah Detail Kegiatan</h5>
                                </a>
                            </div>
                        </div>
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

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="alert alert-danger mt-2 mx-4">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Modal for Creating New Detail Kegiatan -->
    <div class="modal fade" id="createDetailActivityModal" tabindex="-1" role="dialog"
        aria-labelledby="createDetailActivityModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createDetailActivityModalLabel">Tambah Detail Kegiatan Baru</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form tambah detail kegiatan -->
                    <form action="{{ route('detail-kegiatan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="id_kegiatan" class="form-label">Kegiatan</label>
                            <select name="id_kegiatan" id="id_kegiatan" class="form-select" required>
                                <option value="">Pilih Kegiatan</option>
                                @foreach ($kegiatanList as $kegiatan)
                                    <option value="{{ $kegiatan->id_kegiatan }}">{{ $kegiatan->nama_kegiatan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="nama_detail_kegiatan" class="form-label">Nama Detail Kegiatan</label>
                            <input type="text" class="form-control" id="nama_detail_kegiatan" name="nama_detail_kegiatan"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi_detail" class="form-label">Deskripsi Detail Kegiatan</label>
                            <textarea class="form-control" id="deskripsi_detail" name="deskripsi_detail" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="id_bph" class="form-label">Divisi BPH</label>
                            <select name="id_bph" id="id_bph" class="form-select">
                                <option value="">Pilih Divisi</option>
                                @foreach ($bphList as $division)
                                    <option value="{{ $division->id_bph }}">{{ $division->nama_divisi_bph }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
                        </div>
                        <div class="mb-3">
                            <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                            <input type="time" class="form-control" id="waktu_mulai" name="waktu_mulai" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai"
                                required>
                            <div id="tanggalError" class="text-danger mt-1" style="display: none;">
                                Tanggal selesai tidak boleh lebih awal dari tanggal mulai.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="waktu_selesai" class="form-label">Waktu Selesai</label>
                            <input type="time" class="form-control" id="waktu_selesai" name="waktu_selesai" required>
                            <div id="waktuError" class="text-danger mt-1" style="display: none;">
                                Waktu selesai tidak boleh lebih awal dari waktu mulai jika tanggalnya sama.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="lokasi" class="form-label">Lokasi</label>
                            <input type="text" class="form-control" id="lokasi" name="lokasi" required>
                        </div>
                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto Kegiatan</label>
                            <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
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
