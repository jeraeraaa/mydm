<x-layout></x-layout>
<main class="relative isolate px-6 pt-28 lg:px-8 bg-gray-50">
    <div class="max-w-7xl px-4 lg:px-6 py-6 mx-auto">
        <div class="mb-4 sm:mb-6 max-w-3xl text-center mx-auto">
            <h2 class="text-2xl font-bold md:text-4xl md:leading-tight">Coming Soon</h2>
            <p class="text-gray-600 mt-2">Lihat kegiatan apa saja yang akan diadakan Dharmayana.</p>
        </div>
    </div>

    {{-- <div class="max-w-[85rem] px-4 sm:px-6 lg:px-8 mx-auto">
        <div class="grid lg:grid-cols-2 lg:gap-y-12 gap-8">
            @forelse ($kegiatan as $item)
                <a class="group block rounded-xl overflow-hidden focus:outline-none" href="#">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-5">
                        <div class="shrink-0 relative rounded-xl overflow-hidden w-full sm:w-56 h-44">
                            <img class="group-hover:scale-105 group-focus:scale-105 transition-transform duration-500 ease-in-out size-full absolute top-0 start-0 object-cover rounded-xl"
                                src="{{ $item->foto ? url('storage/' . $item->foto) : 'https://via.placeholder.com/150' }}"
                                alt="{{ $item->nama_detail_kegiatan }}">
                        </div>
                        <div class="grow">
                            <h3 class="text-xl font-semibold text-gray-800 group-hover:text-gray-600">
                                {{ $item->nama_detail_kegiatan }}
                            </h3>
                            <p class="mt-2 text-gray-600">
                                {{ $item->deskripsi_detail }}
                            </p>
                            <p class="mt-1 text-sm text-gray-500">
                                📅 {{ $item->tanggal_mulai->format('d M Y') }}
                                🕒 {{ $item->waktu_mulai }}
                            </p>
                            <p class="mt-1 text-sm text-gray-500">
                                📍 {{ $item->lokasi }}
                            </p>
                            <p
                                class="mt-3 inline-flex items-center gap-x-1 text-sm text-blue-600 decoration-2 group-hover:underline group-focus:underline font-medium">
                                <!-- Kurangi margin atas -->
                                Read more
                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m9 18 6-6-6-6" />
                                </svg>
                            </p>
                        </div>
                    </div>
                </a>
            @empty
                <div class="text-center">
                    <p class="text-gray-600">Belum ada kegiatan yang akan dilaksanakan.</p>
                </div>
            @endforelse
        </div>
    </div> --}}




    <!-- Kegiatan yang Akan Datang -->
    <div class="max-w-[85rem] px-4 py-8 sm:px-6 lg:px-8 lg:py-10 mx-auto">
        <div class="grid lg:grid-cols-2 lg:gap-y-16 gap-10">
            @forelse ($kegiatanMendatang as $item)
                <a class="group block rounded-xl overflow-hidden focus:outline-none"
                    href="{{ route('frontend-kegiatan.show', $item->id_detail_kegiatan) }}">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-5">
                        <div class="shrink-0 relative rounded-xl overflow-hidden w-full sm:w-56 h-44">
                            <img class="group-hover:scale-105 group-focus:scale-105 transition-transform duration-500 ease-in-out size-full absolute top-0 start-0 object-cover rounded-xl"
                                src="{{ $item->foto ? url('storage/' . $item->foto) : 'https://via.placeholder.com/150' }}"
                                alt="{{ $item->nama_detail_kegiatan }}">
                        </div>
                        <div class="grow">
                            <h3 class="text-xl font-semibold text-gray-800 group-hover:text-gray-600">
                                {{ $item->nama_detail_kegiatan }}
                            </h3>
                            <p class="mt-3 text-gray-600">
                                {{ $item->deskripsi_detail }}
                            </p>
                            <p class="mt-1 text-sm text-gray-500">
                                📅 {{ $item->tanggal_mulai->format('d M Y') }}
                                🕒 {{ $item->waktu_mulai }}
                            </p>
                            <p class="mt-1 text-sm text-gray-500">
                                📍 {{ $item->lokasi }}
                            </p>
                            <p
                                class="mt-4 inline-flex items-center gap-x-1 text-sm text-blue-600 decoration-2 group-hover:underline group-focus:underline font-medium">
                                Read more
                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m9 18 6-6-6-6" />
                                </svg>
                            </p>
                        </div>
                    </div>
                </a>
            @empty
                <div class="text-center">
                    <p class="text-gray-600">Belum ada kegiatan yang akan dilaksanakan.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Kegiatan yang Telah Dilaksanakan -->
    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <div class="max-w-2xl text-center mx-auto mb-10 lg:mb-14">
            <h2 class="text-2xl font-bold md:text-4xl md:leading-tight">Our Latest Activities</h2>
            <p class="mt-1 text-gray-600">Lihat beberapa kegiatan yang sudah selesai kami adakan.</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10 lg:mb-14">
            @forelse ($kegiatanSelesai as $item)
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
                            📅 {{ $item->tanggal_mulai->format('d M Y') }} -
                            {{ $item->tanggal_selesai->format('d M Y') }}
                        </p>
                    </div>
                </a>
            @empty
                <div class="text-center">
                    <p class="text-gray-600">Belum ada kegiatan yang selesai dilaksanakan.</p>
                </div>
            @endforelse
        </div>
    </div>


</main>
<x-footers></x-footers>
