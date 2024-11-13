@extends('layouts.user_type.auth')

@section('content')
    <div class="col-12">
        <div class="card mb-4 mx-4">
            <div class="card-header pb-0">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <h5 class="mb-0">{{ $detailKegiatan->nama_detail_kegiatan }}</h5>
                        <p class="text-sm text-muted">Detail lengkap dari kegiatan</p>
                    </div>
                    <div>
                        <!-- Tombol Kembali ke Daftar Kegiatan -->
                        <a href="{{ route('detail-kegiatan.index') }}" class="btn btn-outline-primary btn-sm mb-0">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Image Section -->
                    <div class="col-xl-5 col-md-6 mb-4">
                        <img src="{{ $detailKegiatan->foto ? url('storage/' . $detailKegiatan->foto) : asset('assets/img/defaultbarang.jpg') }}"
                            alt="Activity Photo" class="img-fluid shadow border-radius-xl"
                            style="width: 100%; height: auto; object-fit: cover;">

                        <div class="mt-3">
                            <!-- Tombol Edit Detail Kegiatan -->
                            <a href="{{ route('detail-kegiatan.edit', $detailKegiatan->id_detail_kegiatan) }}"
                                class="btn bg-gradient-primary btn-sm mb-0">
                                <i class="fas fa-edit"></i>&nbsp; Edit
                            </a>
                        </div>
                    </div>

                    <!-- Details Section -->
                    <div class="col-xl-7 col-md-6">
                        <h6 class="text-secondary">Informasi Kegiatan</h6>
                        <p class="text-sm mb-2"><strong>Nama Kegiatan:</strong> {{ $detailKegiatan->nama_detail_kegiatan }}
                        </p>
                        <p class="text-sm mb-2"><strong>Deskripsi:</strong>
                            {{ $detailKegiatan->deskripsi_detail ?? 'Tidak ada Deskripsi' }}</p>
                        <p class="text-sm mb-2"><strong>Lokasi:</strong> {{ $detailKegiatan->lokasi }}</p>

                        <hr class="my-3">

                        <h6 class="text-secondary">Waktu dan Tanggal</h6>
                        <p class="text-sm mb-2"><strong>Tanggal Mulai:</strong>
                            {{ $detailKegiatan->tanggal_mulai ? \Carbon\Carbon::parse($detailKegiatan->tanggal_mulai)->format('d/m/Y') : '-' }}
                        </p>
                        <p class="text-sm mb-2"><strong>Waktu Mulai:</strong>
                            {{ $detailKegiatan->waktu_mulai ? \Carbon\Carbon::parse($detailKegiatan->waktu_mulai)->format('H:i') : '-' }}
                        </p>
                        <p class="text-sm mb-2"><strong>Tanggal Selesai:</strong>
                            {{ $detailKegiatan->tanggal_selesai ? \Carbon\Carbon::parse($detailKegiatan->tanggal_selesai)->format('d/m/Y') : '-' }}
                        </p>
                        <p class="text-sm mb-2"><strong>Waktu Selesai:</strong>
                            {{ $detailKegiatan->waktu_selesai ? \Carbon\Carbon::parse($detailKegiatan->waktu_selesai)->format('H:i') : '-' }}
                        </p>

                        <hr class="my-3">

                        <h6 class="text-secondary">Divisi BPH</h6>
                        <p class="text-sm mb-2"><strong>Divisi:</strong>
                            {{ $detailKegiatan->bph->nama_divisi_bph ?? 'Tidak ada Divisi' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
