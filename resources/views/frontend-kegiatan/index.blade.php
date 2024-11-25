@extends('mydm')
@section('title', 'Kegiatan')
@section('content')
    <main class="relative isolate px-6 pt-28 lg:px-8 bg-gray-50">

        {{-- Kegiatan Hari Ini --}}
        <div class="max-w-7xl px-4 lg:px-6 py-6 mx-auto">
            <div class="mb-4 sm:mb-6 max-w-3xl text-center mx-auto">
                <h2 class="text-2xl font-bold md:text-4xl md:leading-tight">Today's Activity</h2>
                <p class="text-gray-600 mt-2">Jangan lewatkan kegiatan pada hari ini!</p>
            </div>

            @if ($kegiatanHariIni->isEmpty())
                <div class="text-center">
                    <p class="text-gray-600">Tidak ada kegiatan yang sedang berlangsung hari ini.</p>
                </div>
            @else
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10 lg:mb-14">
                    @foreach ($kegiatanHariIni as $item)
                        <a class="group flex flex-col bg-white border shadow-sm rounded-xl hover:shadow-md focus:outline-none focus:shadow-md transition"
                            href="{{ route('frontend-kegiatan.show', $item->id_detail_kegiatan) }}">
                            <div class="aspect-w-16 aspect-h-9">
                                <img class="w-full object-cover rounded-t-xl"
                                    src="{{ $item->foto ? url('storage/' . $item->foto) : asset('assets/img/defaultbarang.jpg') }}"
                                    alt="{{ $item->nama_detail_kegiatan }}">
                            </div>
                            <div class="p-4 md:p-5">
                                <p class="mt-2 text-xs uppercase text-gray-600">
                                    Sedang Berlangsung
                                </p>
                                <h3 class="mt-2 text-lg font-medium text-gray-800 group-hover:text-blue-600">
                                    {{ $item->nama_detail_kegiatan }}
                                </h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    📅 {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }} -
                                    {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}
                                </p>
                                <p class="mt-1 text-sm text-gray-500">
                                    📍 {{ $item->lokasi }}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Kegiatan yang Akan Datang --}}
        <div class="max-w-7xl px-4 lg:px-6 py-6 mx-auto">
            <div class="mb-4 sm:mb-6 max-w-3xl text-center mx-auto">
                <h2 class="text-2xl font-bold md:text-4xl md:leading-tight">Upcoming Activities</h2>
                <p class="text-gray-600 mt-2">Lihat kegiatan apa saja yang akan segera diadakan Dharmayana.</p>
            </div>

            @if ($kegiatanMendatang->isEmpty())
                <div class="text-center">
                    <p class="text-gray-600">Belum ada kegiatan yang akan dilaksanakan.</p>
                </div>
            @else
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10 lg:mb-14">
                    @foreach ($kegiatanMendatang as $item)
                        <a class="group flex flex-col bg-white border shadow-sm rounded-xl hover:shadow-md focus:outline-none focus:shadow-md transition"
                            href="{{ route('frontend-kegiatan.show', $item->id_detail_kegiatan) }}">
                            <div class="aspect-w-16 aspect-h-9">
                                <img class="w-full object-cover rounded-t-xl"
                                    src="{{ $item->foto ? url('storage/' . $item->foto) : asset('assets/img/defaultbarang.jpg') }}"
                                    alt="{{ $item->nama_detail_kegiatan }}">
                            </div>
                            <div class="p-4 md:p-5">
                                <p class="mt-2 text-xs uppercase text-gray-600">
                                    Akan Datang
                                </p>
                                <h3 class="mt-2 text-lg font-medium text-gray-800 group-hover:text-blue-600">
                                    {{ $item->nama_detail_kegiatan }}
                                </h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    📅 {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }} -
                                    {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}
                                </p>
                                <p class="mt-1 text-sm text-gray-500">
                                    📍 {{ $item->lokasi }}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Kegiatan yang Telah Dilaksanakan --}}
        <div class="max-w-7xl px-4 lg:px-6 py-6 mx-auto">
            <div class="mb-4 sm:mb-6 max-w-3xl text-center mx-auto">
                <h2 class="text-2xl font-bold md:text-4xl md:leading-tight">Our Latest Activities</h2>
                <p class="text-gray-600 mt-2">Lihat beberapa kegiatan yang sudah selesai kami adakan.</p>
            </div>

            @if ($kegiatanSelesai->isEmpty())
                <div class="text-center">
                    <p class="text-gray-600">Belum ada kegiatan yang selesai dilaksanakan.</p>
                </div>
            @else
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10 lg:mb-14">
                    @foreach ($kegiatanSelesai as $item)
                        <a class="group flex flex-col bg-white border shadow-sm rounded-xl hover:shadow-md focus:outline-none focus:shadow-md transition"
                            href="{{ route('frontend-kegiatan.show', $item->id_detail_kegiatan) }}">
                            <div class="aspect-w-16 aspect-h-9">
                                <img class="w-full object-cover rounded-t-xl"
                                    src="{{ $item->foto ? url('storage/' . $item->foto) : asset('assets/img/defaultbarang.jpg') }}"
                                    alt="{{ $item->nama_detail_kegiatan }}">
                            </div>
                            <div class="p-4 md:p-5">
                                <p class="mt-2 text-xs uppercase text-gray-600">
                                    Selesai
                                </p>
                                <h3 class="mt-2 text-lg font-medium text-gray-800 group-hover:text-blue-600">
                                    {{ $item->nama_detail_kegiatan }}
                                </h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    📅 {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }} -
                                    {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </main>
    <x-footers></x-footers>
@endsection
