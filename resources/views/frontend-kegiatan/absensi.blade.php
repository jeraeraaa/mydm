<x-layout></x-layout>
<main class="relative isolate px-6 pt-6 lg:px-8 bg-gray-50">
    <div class="max-w-5xl px-4 pt-6 lg:pt-10 pb-12 sm:px-6 lg:px-8 mx-auto">
        <div class="mx-auto max-w-2xl">
            <div class="text-center">
                <h2 class="text-xl text-gray-800 font-bold sm:text-3xl">
                    Form Absensi
                </h2>
                <p class="mt-2 text-gray-600">
                    Silakan isi form di bawah untuk melakukan absensi pada kegiatan ini.
                </p>
            </div>

            <!-- Pesan Sukses atau Error -->
            @if (session('success'))
                <div class="mt-4 p-4 text-green-700 bg-green-100 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mt-4 p-4 text-red-700 bg-red-100 rounded-lg">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Absensi -->
            <div class="mt-5 p-4 bg-white border rounded-xl">
                <form action="{{ route('frontend-kegiatan.storeAbsensi', $detailKegiatan->id_detail_kegiatan) }}"
                    method="POST">
                    @csrf
                    <input type="hidden" name="id_detail_kegiatan" value="{{ $detailKegiatan->id_detail_kegiatan }}">

                    <div class="mb-4">
                        <label for="status_absen" class="block mb-2 text-sm font-medium">Anda adalah:</label>
                        <div class="flex items-center gap-4">
                            <label class="flex items-center">
                                <input type="radio" name="status_absen" value="anggota" id="anggota_radio" required
                                    class="mr-2">
                                Anggota
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="status_absen" value="pengunjung" id="pengunjung_radio"
                                    required class="mr-2">
                                Pengunjung
                            </label>
                        </div>
                    </div>

                    <!-- Bagian Anggota -->
                    <div id="anggota_form" class="hidden">
                        <div class="mb-4">
                            <label for="id_anggota" class="block mb-2 text-sm font-medium">NIM/ID Anggota</label>
                            <input type="text" id="id_anggota" name="id_anggota"
                                class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500"
                                placeholder="Masukkan NIM/ID anggota">
                        </div>
                    </div>

                    <!-- Bagian Pengunjung -->
                    <div id="pengunjung_form" class="hidden">
                        <div class="mb-4">
                            <label for="nama_pengunjung" class="block mb-2 text-sm font-medium">Nama Pengunjung</label>
                            <input type="text" id="nama_pengunjung" name="nama_pengunjung"
                                class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500"
                                placeholder="Masukkan nama pengunjung">
                        </div>
                        <div class="mb-4">
                            <label for="no_hp" class="block mb-2 text-sm font-medium">Nomor HP</label>
                            <input type="text" id="no_hp" name="no_hp"
                                class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500"
                                placeholder="Masukkan nomor HP">
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit"
                            class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg bg-orange-600 text-white hover:bg-orange-700 focus:outline-none">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
            <!-- End Form -->
        </div>
    </div>
</main>
<x-footers></x-footers>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const anggotaRadio = document.getElementById('anggota_radio');
        const pengunjungRadio = document.getElementById('pengunjung_radio');
        const anggotaForm = document.getElementById('anggota_form');
        const pengunjungForm = document.getElementById('pengunjung_form');

        anggotaRadio.addEventListener('change', () => {
            if (anggotaRadio.checked) {
                anggotaForm.classList.remove('hidden');
                pengunjungForm.classList.add('hidden');
            }
        });

        pengunjungRadio.addEventListener('change', () => {
            if (pengunjungRadio.checked) {
                pengunjungForm.classList.remove('hidden');
                anggotaForm.classList.add('hidden');
            }
        });
    });
</script>
