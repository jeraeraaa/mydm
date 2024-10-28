

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold mb-4">Tambah Anggota</h2>
            <form action="{{ route('anggota.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-12">
                    <div class="border-b border-gray-900/10 pb-12">
                        <h2 class="text-base font-semibold leading-7 text-gray-900">Profile</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-600">Informasi ini akan ditampilkan secara publik, jadi
                            berhati-hatilah dalam berbagi.</p>

                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-4">
                                <label for="nama_anggota" class="block text-sm font-medium leading-6 text-gray-900">Nama
                                    Lengkap</label>
                                <div class="mt-2">
                                    <input type="text" name="nama_anggota" id="nama_anggota"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                        required>
                                </div>
                            </div>

                            <div class="sm:col-span-4">
                                <label for="email"
                                    class="block text-sm font-medium leading-6 text-gray-900">Email</label>
                                <div class="mt-2">
                                    <input type="email" name="email" id="email"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                        required>
                                </div>
                            </div>

                            <div class="sm:col-span-4">
                                <label for="password"
                                    class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                                <div class="mt-2">
                                    <input type="password" name="password" id="password"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                        required>
                                </div>
                            </div>

                            <div class="sm:col-span-4">
                                <label for="id_prodi"
                                    class="block text-sm font-medium leading-6 text-gray-900">Prodi</label>
                                <div class="mt-2">
                                    <select id="id_prodi" name="id_prodi"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                        required>
                                        @foreach ($prodi as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama_prodi }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="sm:col-span-4">
                                <label for="no_hp" class="block text-sm font-medium leading-6 text-gray-900">No
                                    HP</label>
                                <div class="mt-2">
                                    <input type="text" name="no_hp" id="no_hp"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                        required>
                                </div>
                            </div>

                            <div class="sm:col-span-4">
                                <label for="tanggal_lahir" class="block text-sm font-medium leading-6 text-gray-900">Tanggal
                                    Lahir</label>
                                <div class="mt-2">
                                    <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                        required>
                                </div>
                            </div>

                            <div class="sm:col-span-4">
                                <label for="alamat"
                                    class="block text-sm font-medium leading-6 text-gray-900">Alamat</label>
                                <div class="mt-2">
                                    <input type="text" name="alamat" id="alamat"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                        required>
                                </div>
                            </div>

                            <div class="sm:col-span-4">
                                <label for="jenis_kelamin" class="block text-sm font-medium leading-6 text-gray-900">Jenis
                                    Kelamin</label>
                                <div class="mt-2">
                                    <select id="jenis_kelamin" name="jenis_kelamin"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                        required>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-span-full">
                                <label for="foto_profil" class="block text-sm font-medium leading-6 text-gray-900">Foto
                                    Profil</label>
                                <div class="mt-2 flex items-center gap-x-3">
                                    <input type="file" name="foto_profil" id="foto_profil" class="text-sm text-gray-500">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end gap-x-6">
                    <a href="{{ route('anggota.index') }}" class="text-sm font-semibold leading-6 text-gray-900">Cancel</a>
                    <button type="submit"
                        class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection
