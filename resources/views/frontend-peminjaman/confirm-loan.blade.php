<!-- resources/views/frontend-peminjaman/confirm-loan.blade.php -->
<x-layout></x-layout>

<div class="w-full pt-24">
    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">

        <!-- Invoice Header -->
        <div class="mb-5 pb-5 flex justify-between items-center border-b border-gray-200">
            <h2 class="text-2xl font-semibold text-gray-800">Konfirmasi Peminjaman</h2>
        </div>

        <form action="{{ route('alat.frontend.checkout') }}" method="POST">
            @csrf
            <!-- Detail Peminjam -->
            <div class="border border-gray-200 p-4 rounded-lg space-y-3 mb-8">
                <h3 class="text-xl font-semibold text-gray-800">Detail Peminjam</h3>

                <!-- Radio Button: Pilihan Peminjam -->
                <div class="mt-4 space-y-2">
                    <label>
                        <input type="radio" name="jenis_peminjam" value="pribadi" class="mr-2 jenis-peminjam" checked>
                        Pribadi
                    </label>
                    @auth
                        @if (
                            (Auth::user()->role && Auth::user()->role->name === 'super_user') ||
                                Auth::user()->role->name === 'admin' ||
                                Auth::user()->role->name === 'inventaris')
                            <label>
                                <input type="radio" name="jenis_peminjam" value="eksternal" class="mr-2 jenis-peminjam">
                                Peminjam Eksternal
                            </label>
                        @endif
                    @endauth

                </div>

                <!-- Form Data Peminjam Pribadi -->
                <div id="peminjam-pribadi" class="mt-4 space-y-3">
                    @foreach (['Nama' => 'nama', 'NIM' => 'nim', 'Fakultas' => 'fakultas', 'Jurusan' => 'jurusan', 'Organisasi' => 'organisasi'] as $label => $field)
                        <dl class="flex flex-col gap-x-3 text-sm">
                            <dt class="text-gray-500">{{ $label }}:</dt>
                            <dd class="font-medium text-gray-800">{{ $peminjamData[$field] }}</dd>
                        </dl>
                    @endforeach
                </div>
                @auth
                    @if (
                        (Auth::user()->role && Auth::user()->role->name === 'super_user') ||
                            Auth::user()->role->name === 'admin' ||
                            Auth::user()->role->name === 'inventaris')
                        <!-- Form Data Peminjam Eksternal -->
                        <div id="peminjam-eksternal" class="mt-4 space-y-3 hidden">
                            <div>
                                <label class="block text-gray-500">Nama:</label>
                                <input type="text" name="nama_eksternal" id="nama_eksternal"
                                    class="w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                            <div>
                                <label class="block text-gray-500">NIM/ID:</label>
                                <input type="text" name="id_eksternal" id="id_eksternal"
                                    class="w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                            <div>
                                <label class="block text-gray-500">Organisasi:</label>
                                <input type="text" name="organisasi_eksternal" id="organisasi_eksternal"
                                    class="w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                        </div>
                    @endif
                @endauth
            </div>

            <!-- Item Table -->
            <div class="border border-gray-200 p-4 rounded-lg space-y-4 mb-8">
                <div class="hidden sm:grid sm:grid-cols-5 gap-3 text-sm font-medium text-gray-500 uppercase">
                    <div class="col-span-2">Item</div>
                    <div class="col-span-3 text-right">Jumlah</div>
                </div>
                <div class="border-b border-gray-200"></div>
                @foreach ($selectedCart as $id => $item)
                    <div class="grid grid-cols-2 sm:grid-cols-5 gap-3 items-center">
                        <div class="flex items-center gap-4 col-span-2">
                            <img src="{{ $item['foto'] ? url('storage/' . $item['foto']) : asset('assets/img/defaultbarang.jpg') }}"
                                class="w-10 h-10 rounded-lg shadow">
                            <span class="font-medium text-gray-800">{{ $item['name'] }}</span>
                        </div>
                        <div class="col-span-3 text-right font-medium text-gray-800">{{ $item['jumlah'] }}</div>
                    </div>
                @endforeach
            </div>

            <!-- Informasi Peminjaman -->
            <div class="border border-gray-200 p-4 rounded-lg space-y-4">
                <h3 class="text-xl font-semibold text-gray-800">Informasi Peminjaman</h3>
                <form action="{{ route('alat.frontend.checkout') }}" method="POST">
                    @csrf

                    <!-- Hidden Input for Jenis Peminjam -->
                    <input type="hidden" name="jenis_peminjam" id="jenis_peminjam_value" value="pribadi">

                    <div class="mt-4 space-y-3">
                        <dl class="flex flex-col gap-x-3 text-sm">
                            <dt class="text-gray-500">Tanggal Peminjaman:</dt>
                            <input type="date" name="tanggal_peminjaman" id="tanggal_peminjaman"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" required>
                        </dl>
                        <dl class="flex flex-col gap-x-3 text-sm">
                            <dt class="text-gray-500">Tanggal Pengembalian:</dt>
                            <input type="date" name="tanggal_pengembalian" id="tanggal_pengembalian"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                value="{{ date('Y-m-d', strtotime('+7 days')) }}"
                                min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                max="{{ date('Y-m-d', strtotime('+10 days')) }}" required>
                        </dl>
                    </div>

                    <!-- Confirmation Button -->
                    <div class="mt-6 text-right">
                        <button type="submit" class="py-2 px-4 bg-orange-500 text-white rounded-lg hover:bg-green-600">
                            Konfirmasi Peminjaman
                        </button>
                    </div>
                </form>
            </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tanggalPeminjaman = document.getElementById('tanggal_peminjaman');
        const tanggalPengembalian = document.getElementById('tanggal_pengembalian');

        tanggalPeminjaman.addEventListener('change', function() {
            const minPengembalian = new Date(this.value);
            minPengembalian.setDate(minPengembalian.getDate() + 1);

            const maxPengembalian = new Date(this.value);
            maxPengembalian.setDate(maxPengembalian.getDate() + 10);

            tanggalPengembalian.min = minPengembalian.toISOString().split('T')[0];
            tanggalPengembalian.max = maxPengembalian.toISOString().split('T')[0];

            if (tanggalPengembalian.value < tanggalPengembalian.min || tanggalPengembalian.value >
                tanggalPengembalian.max) {
                tanggalPengembalian.value = tanggalPengembalian.min;
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const jenisPeminjamRadios = document.querySelectorAll('.jenis-peminjam');
        const peminjamPribadi = document.getElementById('peminjam-pribadi');
        const peminjamEksternal = document.getElementById('peminjam-eksternal');
        const jenisPeminjamValue = document.getElementById('jenis_peminjam_value');

        jenisPeminjamRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'pribadi') {
                    peminjamPribadi.classList.remove('hidden');
                    peminjamEksternal.classList.add('hidden');
                    jenisPeminjamValue.value = 'pribadi';
                } else {
                    peminjamPribadi.classList.add('hidden');
                    peminjamEksternal.classList.remove('hidden');
                    jenisPeminjamValue.value = 'eksternal';
                }
            });
        });
    });
</script>
