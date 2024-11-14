<x-layout></x-layout>

<div class="w-full pt-32">
    <div class="col-12">
        <div class="card mb-4 mx-4">
            <div class="card-header pb-0">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <h5 class="mb-0">{{ $alat->nama_alat }}</h5>
                        <p class="text-sm text-muted">Detail lengkap dari alat</p>
                    </div>
                    <div>
                        <!-- Tombol Kembali ke Daftar Alat -->
                        <a href="{{ route('alat.frontend') }}" class="btn btn-outline-primary btn-sm mb-0">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Image Section -->
                    <div class="col-xl-5 col-md-6 mb-4">
                        <img src="{{ $alat->foto ? url('storage/' . $alat->foto) : asset('assets/img/defaultbarang.jpg') }}"
                            alt="Alat Photo" class="img-fluid shadow border-radius-xl"
                            style="width: 100%; height: auto; object-fit: cover;">
                    </div>

                    <!-- Details Section -->
                    <div class="col-xl-7 col-md-6">
                        <h6 class="text-secondary">Informasi Alat</h6>
                        <p class="text-sm mb-2"><strong>Nama Alat:</strong> {{ $alat->nama_alat }}</p>
                        <p class="text-sm mb-2"><strong>Deskripsi:</strong> {{ $alat->deskripsi ?? 'Tidak ada Deskripsi' }}</p>
                        <p class="text-sm mb-2"><strong>Jumlah Tersedia:</strong> {{ $alat->jumlah_tersedia }}</p>

                        <hr class="my-3">

                        <h6 class="text-secondary">Divisi</h6>
                        <p class="text-sm mb-2"><strong>Divisi BPH:</strong> {{ $alat->bph->nama_divisi_bph ?? 'Tidak ada Divisi' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
