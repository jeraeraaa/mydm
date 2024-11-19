@extends('layouts.user_type.auth')

@section('content')
    @php
        $user = auth()->guard('anggota')->user();
    @endphp

    @if (
        $user->role &&
            ($user->role->name === 'admin' || $user->role->name === 'super_user' || $user->role->name === 'inventaris'))
        <div class="dashboard-content">
            <h3>Welcome to MyDM Dashboard</h3>

            <div class="row">
                <!-- Statistik Total -->
                <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-body p-3">
                            <h6>Total Members</h6>
                            <h5 class="font-weight-bolder">{{ $totalMembers }}</h5>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-body p-3">
                            <h6>Total Borrowings</h6>
                            <h5 class="font-weight-bolder">{{ $totalBorrowings }}</h5>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-body p-3">
                            <h6>Total Detail Activities</h6>
                            <h5 class="font-weight-bolder">{{ $totalDetailKegiatan }}</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <!-- Statistik Anggota Berdasarkan Fakultas -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6>Members by Faculty</h6>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                @foreach ($membersByFaculty as $faculty)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $faculty['nama_fakultas'] }}
                                        <span class="badge bg-primary rounded-pill">{{ $faculty['total_anggota'] }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Statistik Peminjaman Berdasarkan Alat -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6>Top Borrowed Items</h6>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                @foreach ($topBorrowedItems as $item)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $item->alat->nama_alat ?? 'Unknown Item' }}
                                        <span class="badge bg-primary rounded-pill">{{ $item->total }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="no-access">
            <h3>Akses ditolak</h3>
            <p>Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.</p>
            <a href="{{ route('home') }}">Kembali ke Beranda</a>
        </div>
    @endif
@endsection
