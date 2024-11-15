<!-- resources/views/frontend-peminjaman/confirm-loan.blade.php -->
<x-layout></x-layout>

<div class="w-full pt-24">
    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <!-- Invoice Header -->
        <div class="mb-5 pb-5 flex justify-between items-center border-b border-gray-200">
            <div>
                <h2 class="text-2xl font-semibold text-gray-800">Konfirmasi Peminjaman</h2>
            </div>
            <!-- Action Buttons -->
            <div class="inline-flex gap-x-2">
                <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50"
                    href="#">
                    <svg class="shrink-0" width="24" height="24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                        <polyline points="7 10 12 15 17 10" />
                        <line x1="12" x2="12" y1="15" y2="3" />
                    </svg>
                    Invoice PDF
                </a>
                <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700"
                    href="#">
                    <svg class="shrink-0" width="24" height="24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <polyline points="6 9 6 2 18 2 18 9" />
                        <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2" />
                        <rect width="12" height="8" x="6" y="14" />
                    </svg>
                    Print
                </a>
            </div>
        </div>

        <!-- Informasi Peminjam -->
        <div class="grid md:grid-cols-2 gap-3 mb-8">
            <div>
                <h3 class="text-xl font-semibold text-gray-800">Detail Peminjam</h3>
                <div class="mt-4 space-y-3">
                    <dl class="flex flex-col gap-x-3 text-sm">
                        <dt class="text-gray-500">Nama:</dt>
                        <dd class="font-medium text-gray-800">{{ $peminjam->nama ?? 'Tidak Diketahui' }}</dd>
                    </dl>
                    <dl class="flex flex-col gap-x-3 text-sm">
                        <dt class="text-gray-500">NIM:</dt>
                        <dd class="font-medium text-gray-800">{{ $peminjam->nim ?? 'Tidak Diketahui' }}</dd>
                    </dl>
                    <dl class="flex flex-col gap-x-3 text-sm">
                        <dt class="text-gray-500">Fakultas:</dt>
                        <dd class="font-medium text-gray-800">{{ $peminjam->fakultas ?? '-' }}</dd>
                    </dl>
                    <dl class="flex flex-col gap-x-3 text-sm">
                        <dt class="text-gray-500">Jurusan:</dt>
                        <dd class="font-medium text-gray-800">{{ $peminjam->jurusan ?? '-' }}</dd>
                    </dl>
                    <dl class="flex flex-col gap-x-3 text-sm">
                        <dt class="text-gray-500">Organisasi:</dt>
                        <dd class="font-medium text-gray-800">{{ $peminjam->organisasi ?? 'Internal Dharmayana' }}</dd>
                    </dl>
                </div>
            </div>

            <!-- Details -->
            <div>
                <h3 class="text-xl font-semibold text-gray-800">Informasi Peminjaman</h3>
                <div class="mt-4 space-y-3">
                    <dl class="flex flex-col gap-x-3 text-sm">
                        <dt class="text-gray-500">Tanggal Peminjaman:</dt>
                        <input type="date" name="tanggal_peminjaman"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ date('Y-m-d') }}">
                    </dl>
                    <dl class="flex flex-col gap-x-3 text-sm">
                        <dt class="text-gray-500">Tanggal Pengembalian:</dt>
                        <input type="date" name="tanggal_pengembalian"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            value="{{ date('Y-m-d', strtotime('+7 days')) }}">
                    </dl>
                    <dl class="flex flex-col gap-x-3 text-sm">
                        <dt class="text-gray-500">Kegiatan (Tulis nama proker):</dt>
                        <input type="text" name="kegiatan"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </dl>
                </div>
            </div>
        </div>

        <!-- Item Table -->
        <div class="border border-gray-200 p-4 rounded-lg space-y-4">
            <div class="hidden sm:grid sm:grid-cols-5 gap-3 text-sm font-medium text-gray-500 uppercase">
                <div class="col-span-2">Item</div>
                <div class="col-span-3 text-right">Jumlah</div>
            </div>
            <div class="border-b border-gray-200"></div>
            @foreach ($selectedCart as $id => $item)
                <div class="grid grid-cols-2 sm:grid-cols-5 gap-3 items-center">
                    <div class="flex items-center gap-4 col-span-2 sm:col-span-2">
                        <img src="{{ $item['foto'] ? url('storage/' . $item['foto']) : asset('assets/img/defaultbarang.jpg') }}"
                            class="w-10 h-10 rounded-lg shadow">
                        <span class="font-medium text-gray-800">{{ $item['name'] }}</span>
                    </div>
                    <div class="col-span-3 text-right font-medium text-gray-800">{{ $item['jumlah'] }}</div>
                </div>
            @endforeach
        </div>

        <!-- Confirmation Button -->
        <div class="mt-6 text-right">
            <form action="{{ route('alat.frontend.checkout') }}" method="POST">
                @csrf
                <button type="submit" class="py-2 px-4 bg-orange-500 text-white rounded-lg hover:bg-green-600">
                    Konfirmasi Peminjaman
                </button>
            </form>
        </div>
    </div>
</div>
