<x-layout></x-layout>
<main class="relative isolate px-6 pt-6 lg:px-8 bg-gray-50">
    <div class="max-w-5xl px-4 pt-6 lg:pt-10 pb-12 sm:px-6 lg:px-8 mx-auto">
        <div class="max-w-4xl">
            <!-- Detail Kegiatan -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold md:text-3xl">{{ $detailKegiatan->nama_detail_kegiatan }}</h1>
                @if (now()->toDateString() >= $detailKegiatan->tanggal_mulai->toDateString() &&
                        now()->toDateString() <= $detailKegiatan->tanggal_selesai->toDateString())
                    <div class="mt-6">
                        <a href="{{ route('frontend-kegiatan.absensi', $detailKegiatan->id_detail_kegiatan) }}"
                            class="py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg bg-green-600 text-white hover:bg-green-700 focus:outline-none">
                            Absensi
                        </a>
                    </div>
                @endif
                <!-- Deskripsi Kegiatan -->
                @if ($detailKegiatan->kegiatan)
                    <div class="mt-8">
                        <h2 class="text-xl font-semibold">Deskripsi Kegiatan</h2>
                        <p class="text-lg text-gray-800 mt-3">{{ $detailKegiatan->kegiatan->deskripsi_kegiatan }}</p>
                    </div>
                @endif

                <p class="text-lg text-gray-800 mt-3">{{ $detailKegiatan->deskripsi_detail }}</p>
                <div class="mt-4 text-gray-600">
                    <p>📅 Tanggal: {{ $detailKegiatan->tanggal_mulai->format('d M Y') }}
                        @if ($detailKegiatan->tanggal_selesai && $detailKegiatan->tanggal_selesai != $detailKegiatan->tanggal_mulai)
                            - {{ $detailKegiatan->tanggal_selesai->format('d M Y') }}
                        @endif
                    </p>
                    <p>🕒 Waktu: {{ $detailKegiatan->waktu_mulai }}</p>
                    <p>📍 Lokasi: {{ $detailKegiatan->lokasi }}</p>
                </div>
                <img class="w-full object-cover rounded-xl mt-6"
                    src="{{ $detailKegiatan->foto ? url('storage/' . $detailKegiatan->foto) : asset('assets/img/defaultbarang.jpg') }}"
                    alt="{{ $detailKegiatan->nama_detail_kegiatan }}">
            </div>

            <!-- Tombol Absensi -->


            <!-- Materi -->
            @if ($detailKegiatan->materi->count() > 0)
                <div class="mt-8">
                    <h2 class="text-xl font-semibold">Materi</h2>
                    <ul class="mt-4 space-y-4">
                        @foreach ($detailKegiatan->materi as $materi)
                            <li class="border-b pb-4">
                                <p class="font-semibold text-gray-800">{{ $materi->nama_materi }}</p>
                                <p class="text-gray-600">{{ $materi->deskripsi_materi }}</p>
                                @if ($materi->pembicara)
                                    <p class="mt-2 text-sm text-gray-500">📢 Pembicara:
                                        {{ $materi->pembicara->nama_pembicara }}</p>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</main>
<x-footers></x-footers>
