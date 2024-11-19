<x-layout></x-layout>
<main class="relative isolate px-6 pt-12 lg:px-8 bg-gray-50">
    <div class="max-w-6xl px-4 py-10 sm:px-6 lg:px-8 mx-auto">
        <!-- Card -->
        <div class="bg-white rounded-xl shadow p-4 sm:p-7">
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800">
                    Edit Profil Anggota
                </h2>
                <p class="text-sm text-gray-600">
                    Ubah informasi anggota di sini.
                </p>
            </div>

            <form action="{{ route('profile.update', $anggota->id_anggota) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

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
                            {{-- <img class="w-16 h-16 rounded-full border-2 border-gray-300"
                                src="{{ $anggota->foto_profil ? asset('storage/foto_profil/' . $anggota->foto_profil) : asset('assets/img/default-user.png') }}"
                                alt="Foto Profil {{ $anggota->nama_anggota }}"> --}}
                            <img class="inline-block size-16 rounded-full ring-2 ring-white"
                                src="{{ file_exists(public_path('storage/foto_profil/' . $anggota->foto_profil)) && $anggota->foto_profil
                                    ? asset('storage/foto_profil/' . $anggota->foto_profil)
                                    : asset('assets/img/default-user.png') }}"
                                alt="Foto profil {{ $anggota->nama_anggota }}">
                            <div>
                                <label class="text-sm font-medium text-gray-600 block mb-2" for="foto_profil">Unggah
                                    Foto Baru</label>
                                <input type="file" name="foto_profil" id="foto_profil"
                                    class="block w-full text-sm text-gray-500 file:py-2 file:px-4 file:border-0 file:bg-gray-100 file:text-gray-700 file:rounded-lg hover:file:bg-gray-200">
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Format yang diperbolehkan: JPG, PNG. Ukuran maksimum: 2MB.
                        </p>
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

                    <!-- Nama -->
                    <div class="sm:col-span-3">
                        <label class="inline-block text-sm text-gray-800 mt-2.5">
                            Nama Lengkap
                        </label>
                    </div>
                    <div class="sm:col-span-9">
                        <input type="text" name="nama_anggota"
                            class="py-2 px-3 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500"
                            value="{{ old('nama_anggota', $anggota->nama_anggota) }}">
                    </div>

                    <!-- Email -->
                    <div class="sm:col-span-3">
                        <label class="inline-block text-sm text-gray-800 mt-2.5">
                            Email
                        </label>
                    </div>
                    <div class="sm:col-span-9">
                        <input type="email" name="email"
                            class="py-2 px-3 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500"
                            value="{{ old('email', $anggota->email) }}">
                    </div>

                    <!-- No HP -->
                    <div class="sm:col-span-3">
                        <label class="inline-block text-sm text-gray-800 mt-2.5">
                            No HP
                        </label>
                    </div>
                    <div class="sm:col-span-9">
                        <input type="text" name="no_hp"
                            class="py-2 px-3 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500"
                            value="{{ old('no_hp', $anggota->no_hp) }}">
                    </div>

                    <!-- Tanggal Lahir -->
                    <div class="sm:col-span-3">
                        <label class="inline-block text-sm text-gray-800 mt-2.5">
                            Tanggal Lahir
                        </label>
                    </div>
                    <div class="sm:col-span-9">
                        <input type="date" name="tanggal_lahir"
                            class="py-2 px-3 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500"
                            value="{{ old('tanggal_lahir', $anggota->tanggal_lahir) }}">
                    </div>

                    <!-- Jenis Kelamin -->
                    <div class="sm:col-span-3">
                        <label class="inline-block text-sm text-gray-800 mt-2.5">
                            Jenis Kelamin
                        </label>
                    </div>
                    <div class="sm:col-span-9">
                        <select name="jenis_kelamin"
                            class="py-2 px-3 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500">
                            <option value="L"
                                {{ old('jenis_kelamin', $anggota->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki
                            </option>
                            <option value="P"
                                {{ old('jenis_kelamin', $anggota->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan
                            </option>
                        </select>
                    </div>

                    <!-- Alamat -->
                    <div class="sm:col-span-3">
                        <label class="inline-block text-sm text-gray-800 mt-2.5">
                            Alamat
                        </label>
                    </div>
                    <div class="sm:col-span-9">
                        <textarea name="alamat"
                            class="py-2 px-3 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500"
                            rows="3">{{ old('alamat', $anggota->alamat) }}</textarea>
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
                </div>
                <!-- End Grid -->

                <!-- Button Save -->
                <div class="mt-5 flex justify-end gap-2">
                    <a href="{{ route('profile.show', $anggota->id_anggota) }}"
                        class="py-2 px-4 text-sm font-medium rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit"
                        class="py-2 px-4 text-sm font-medium rounded-lg border border-transparent bg-orange-500 text-white hover:bg-orange-700 focus:outline-none focus:bg-orange-700">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
        <!-- End Card -->
    </div>
</main>
<x-footers></x-footers>
