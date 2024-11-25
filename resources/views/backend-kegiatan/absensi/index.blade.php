@extends('layouts.user_type.auth')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <h5 class="mb-0">Daftar Kegiatan</h5>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead class="">
                                    <tr>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-start py-3 px-3">
                                            Nama Kegiatan
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-start py-3 px-3">
                                            Lokasi
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center py-3 px-3">
                                            Tanggal Mulai
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center py-3 px-3">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($details as $detail)
                                        <tr>
                                            <td class="text-start text-wrap py-3 px-3">
                                                <span class="text-xs font-weight-bold">
                                                    {{ $detail->nama_detail_kegiatan }}
                                                </span>
                                            </td>
                                            <td class="text-start text-wrap py-3 px-3">
                                                <span class="text-xs font-weight-bold">
                                                    {{ $detail->lokasi }}
                                                </span>
                                            </td>
                                            <td class="text-center py-3 px-3">
                                                <span class="text-xs font-weight-bold">
                                                    {{ \Carbon\Carbon::parse($detail->tanggal_mulai)->format('d/m/Y') }}
                                                </span>
                                            </td>
                                            <td class="text-center py-3 px-3">
                                                <a href="{{ route('absensi.show', $detail->id_detail_kegiatan) }}"
                                                    class="btn bg-gradient-primary btn-sm px-4">Lihat Detail</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-muted py-3 px-3">
                        <p class="text-sm text-secondary mb-0">Total kegiatan: {{ $details->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success mt-2 mx-4">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger mt-2 mx-4">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger mt-2 mx-4">
                <ul class="m-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    @endsection
