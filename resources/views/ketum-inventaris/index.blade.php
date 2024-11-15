@extends('layouts.user_type.auth')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Dashboard Pengelolaan Data</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="p-4">
                        <!-- Tab Navigation -->
                        <ul class="nav nav-tabs" id="dashboardTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="ketua-umum-tab" data-bs-toggle="tab" href="#ketua-umum"
                                    role="tab" aria-controls="ketua-umum" aria-selected="true">
                                    Data Ketua Umum
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="inventaris-tab" data-bs-toggle="tab" href="#inventaris"
                                    role="tab" aria-controls="inventaris" aria-selected="false">
                                    Data Inventaris
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content mt-3" id="dashboardTabsContent">
                            <!-- Ketua Umum Tab -->
                            <div class="tab-pane fade show active" id="ketua-umum" role="tabpanel"
                                aria-labelledby="ketua-umum-tab">
                                <div class="table-responsive">
                                    <h6>Data Ketua Umum</h6>
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th>ID Ketua Umum</th>
                                                <th>ID Anggota</th>
                                                <th>Tahun Jabatan</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($ketuaUmum as $ketum)
                                                <tr>
                                                    <td>{{ $ketum->id_ketum }}</td>
                                                    <td>{{ $ketum->id_anggota }}</td>
                                                    <td>{{ $ketum->tahun_jabatan }}</td>
                                                    <td class="text-center">
                                                        <a href="#" class="btn btn-link p-0 m-0"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editKetumModal-{{ $ketum->id_ketum }}">
                                                            <i class="fas fa-edit text-secondary"></i>
                                                        </a>
                                                        <form action="{{ route('ketua-umum.delete', $ketum->id_ketum) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-link p-0 m-0"
                                                                onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                                <i class="fas fa-trash text-secondary"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- Inventaris Tab -->
                            <div class="tab-pane fade" id="inventaris" role="tabpanel" aria-labelledby="inventaris-tab">
                                <div class="table-responsive">
                                    <h6>Data Inventaris</h6>
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th>ID Inventaris</th>
                                                <th>ID Anggota</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($inventaris as $item)
                                                <tr>
                                                    <td>{{ $item->id_inventaris }}</td>
                                                    <td>{{ $item->id_anggota }}</td>
                                                    <td class="text-center">
                                                        <a href="#" class="btn btn-link p-0 m-0"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editInventarisModal-{{ $item->id_inventaris }}">
                                                            <i class="fas fa-edit text-secondary"></i>
                                                        </a>
                                                        <form
                                                            action="{{ route('inventaris.delete', $item->id_inventaris) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-link p-0 m-0"
                                                                onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                                <i class="fas fa-trash text-secondary"></i>
                                                            </button>
                                                        </form>
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
            </div>
        </div>
    </div>
@endsection
