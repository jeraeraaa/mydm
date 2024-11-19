<x-layout></x-layout>
<main class="relative isolate px-6 pt-12 lg:px-8 bg-gray-50">
    <div class="max-w-6xl px-4 py-10 sm:px-6 lg:px-8 mx-auto">
        <!-- Card -->
        <div class="bg-white rounded-xl shadow p-4 sm:p-7">
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800">
                    Profil Anggota
                </h2>
                <p class="text-sm text-gray-600">
                    Informasi tentang anggota dan pengaturan akun.
                </p>
            </div>

            <form>
                <!-- Grid -->
                <div class="grid sm:grid-cols-12 gap-2 sm:gap-6">
                    <!-- Foto Profil -->
                    <div class="sm:col-span-3">
                        <label class="inline-block text-sm text-gray-800 mt-2.5">
                            Foto Profil
                        </label>
                    </div>
                    <div class="sm:col-span-9">
                        <div class="flex items-center gap-5">
                            <img class="inline-block size-16 rounded-full ring-2 ring-white"
                                src="{{ file_exists(public_path('storage/foto_profil/' . $anggota->foto_profil)) && $anggota->foto_profil
                                    ? asset('storage/foto_profil/' . $anggota->foto_profil)
                                    : asset('assets/img/default-user.png') }}"
                                alt="Foto profil {{ $anggota->nama_anggota }}">
                        </div>
                    </div>

                    <!-- Nama -->
                    <div class="sm:col-span-3">
                        <label class="inline-block text-sm text-gray-800 mt-2.5">
                            Nama Lengkap
                        </label>
                    </div>
                    <div class="sm:col-span-9">
                        <input type="text"
                            class="py-2 px-3 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500"
                            value="{{ $anggota->nama_anggota }}" disabled>
                    </div>

                    <!-- NIM -->
                    <div class="sm:col-span-3">
                        <label class="inline-block text-sm text-gray-800 mt-2.5">
                            NIM
                        </label>
                    </div>
                    <div class="sm:col-span-9">
                        <input type="text"
                            class="py-2 px-3 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500"
                            value="{{ $anggota->id_anggota }}" disabled>
                    </div>

                    <!-- Email -->
                    <div class="sm:col-span-3">
                        <label class="inline-block text-sm text-gray-800 mt-2.5">
                            Email
                        </label>
                    </div>
                    <div class="sm:col-span-9">
                        <input type="email"
                            class="py-2 px-3 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500"
                            value="{{ $anggota->email }}" disabled>
                    </div>

                    <!-- Tanggal Lahir -->
                    <div class="sm:col-span-3">
                        <label class="inline-block text-sm text-gray-800 mt-2.5">
                            Tanggal Lahir
                        </label>
                    </div>
                    <div class="sm:col-span-9">
                        <input type="text"
                            class="py-2 px-3 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:orange-blue-500 focus:ring-orange-500"
                            value="{{ \Carbon\Carbon::parse($anggota->tanggal_lahir)->format('d M Y') }}" disabled>
                    </div>

                    <!-- Fakultas -->
                    <div class="sm:col-span-3">
                        <label class="inline-block text-sm text-gray-800 mt-2.5">
                            Fakultas
                        </label>
                    </div>
                    <div class="sm:col-span-9">
                        <input type="text"
                            class="py-2 px-3 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500"
                            value="{{ $anggota->prodi->fakultas->nama_fakultas ?? '-' }}" disabled>
                    </div>

                    <!-- Program Studi -->
                    <div class="sm:col-span-3">
                        <label class="inline-block text-sm text-gray-800 mt-2.5">
                            Program Studi
                        </label>
                    </div>
                    <div class="sm:col-span-9">
                        <input type="text"
                            class="py-2 px-3 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500"
                            value="{{ $anggota->prodi->nama_prodi ?? '-' }}" disabled>
                    </div>

                    <!-- Jenis Kelamin -->
                    <div class="sm:col-span-3">
                        <label class="inline-block text-sm text-gray-800 mt-2.5">
                            Jenis Kelamin
                        </label>
                    </div>
                    <div class="sm:col-span-9">
                        <input type="text"
                            class="py-2 px-3 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500"
                            value="{{ $anggota->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}" disabled>
                    </div>

                    <!-- Alamat -->
                    <div class="sm:col-span-3">
                        <label class="inline-block text-sm text-gray-800 mt-2.5">
                            Alamat
                        </label>
                    </div>
                    <div class="sm:col-span-9">
                        <textarea
                            class="py-2 px-3 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500"
                            rows="3" disabled>{{ $anggota->alamat }}</textarea>
                    </div>
                </div>
                <!-- End Grid -->

                <!-- Button Edit -->
                <div class="mt-5 flex justify-end">
                    <a href="{{ route('profile.edit', $anggota->id_anggota) }}"
                        class="py-2 px-4 text-sm font-medium rounded-lg border border-transparent bg-orange-500 text-white hover:bg-orange-700 focus:outline-none focus:bg-orange-700">
                        Edit Profil
                    </a>
                </div>
            </form>
        </div>
        <!-- End Card -->

        <!-- Riwayat Peminjaman -->
        <div class="mt-10">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Riwayat Peminjaman</h3>
            @if ($riwayatPeminjaman->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg shadow-md border border-gray-200">
                        <thead class="bg-gray-50 text-gray-600 uppercase text-sm leading-normal">
                            <tr>
                                <th class="py-3 px-6 text-left">No</th>
                                <th class="py-3 px-6 text-left">Nama Alat</th>
                                <th class="py-3 px-6 text-left">Tanggal Pinjam</th>
                                <th class="py-3 px-6 text-left">Tanggal Kembali</th>
                                <th class="py-3 px-6 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($riwayatPeminjaman as $peminjaman)
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="py-3 px-6">{{ $loop->iteration }}</td>
                                    <td class="py-3 px-6">{{ $peminjaman->alat->nama_alat ?? '-' }}</td>
                                    <td class="py-3 px-6">
                                        {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}
                                    </td>
                                    <td class="py-3 px-6">
                                        {{ $peminjaman->tanggal_kembali ? \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d M Y') : 'Belum Dikembalikan' }}
                                    </td>
                                    {{-- <td class="py-3 px-6">
                                        <!-- Status -->
                                        @if (!$peminjaman->is_approved && !$peminjaman->is_rejected)
                                            <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded">
                                                Menunggu Persetujuan
                                            </span>
                                        @elseif ($peminjaman->is_rejected)
                                            <span class="px-2 py-1 bg-red-100 text-red-700 rounded">
                                                Ditolak
                                            </span>
                                        @elseif ($peminjaman->tanggal_kembali)
                                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded">
                                                Dikembalikan
                                            </span>
                                        @else
                                            <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded">
                                                Dipinjam
                                            </span>
                                        @endif
                                    </td> --}}

                                    <td class="py-3 px-6">
                                        @php
                                            $statusClasses = [
                                                'menunggu persetujuan' => 'bg-yellow-100 text-yellow-700',
                                                'ditolak' => 'bg-red-100 text-red-700',
                                                'dipinjam' => 'bg-blue-100 text-blue-700',
                                                'dikembalikan' => 'bg-green-100 text-green-700',
                                            ];
                                        @endphp

                                        <span
                                            class="px-2 py-1 rounded {{ $statusClasses[$peminjaman->status_peminjaman] ?? 'bg-gray-100 text-gray-700' }}">
                                            {{ ucfirst($peminjaman->status_peminjaman) }}
                                        </span>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-600">Tidak ada riwayat peminjaman.</p>
            @endif
        </div>

        <!-- Riwayat Absensi -->
        <div class="mt-10">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Riwayat Absensi</h3>
            @if ($riwayatKegiatan->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg shadow-md border border-gray-200">
                        <thead class="bg-gray-50 text-gray-600 uppercase text-sm leading-normal">
                            <tr>
                                <th class="py-3 px-6 text-left">No</th>
                                <th class="py-3 px-6 text-left">Nama Kegiatan</th>
                                <th class="py-3 px-6 text-left">Lokasi</th>
                                <th class="py-3 px-6 text-left">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($riwayatKegiatan as $kegiatan)
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="py-3 px-6">{{ $loop->iteration }}</td>
                                    <td class="py-3 px-6">{{ $kegiatan->detailKegiatan->nama_detail_kegiatan ?? '-' }}
                                    </td>
                                    <td class="py-3 px-6">{{ $kegiatan->detailKegiatan->lokasi ?? '-' }}</td>
                                    <td class="py-3 px-6">
                                        {{ $kegiatan->detailKegiatan->tanggal_mulai ? \Carbon\Carbon::parse($kegiatan->detailKegiatan->tanggal_mulai)->format('d M Y') : '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-600">Tidak ada riwayat absensi.</p>
            @endif
        </div>

    </div>
</main>
<x-footers></x-footers>
