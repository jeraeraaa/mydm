<!-- resources/views/frontend-peminjaman/confirm-loan.blade.php -->
<x-layout></x-layout>

<div class="w-full pt-24">
    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        
        <!-- Invoice Header -->
        <div class="mb-5 pb-5 flex justify-between items-center border-b border-gray-200">
            <h2 class="text-2xl font-semibold text-gray-800">Konfirmasi Peminjaman</h2>
            <div class="inline-flex gap-x-2">
                <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50" href="#">
                    <svg class="shrink-0" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                        <polyline points="7 10 12 15 17 10" />
                        <line x1="12" x2="12" y1="15" y2="3" />
                    </svg>
                    Invoice PDF
                </a>
                <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700" href="#">
                    <svg class="shrink-0" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="6 9 6 2 18 2 18 9" />
                        <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1-2 2v5a2 2 0 0 1-2 2h-2" />
                        <rect width="12" height="8" x="6" y="14" />
                    </svg>
                    Print
                </a>
            </div>
        </div>

        <!-- Detail Peminjam -->
        <div class="border border-gray-200 p-4 rounded-lg space-y-3 mb-8">
            <h3 class="text-xl font-semibold text-gray-800">Detail Peminjam</h3>
            <div class="mt-4 space-y-3">
                @foreach (['Nama' => 'nama', 'NIM' => 'nim', 'Fakultas' => 'fakultas', 'Jurusan' => 'jurusan', 'Organisasi' => 'organisasi'] as $label => $field)
                    <dl class="flex flex-col gap-x-3 text-sm">
                        <dt class="text-gray-500">{{ $label }}:</dt>
                        <dd class="font-medium text-gray-800">{{ $peminjamData[$field] }}</dd>
                    </dl>
                @endforeach
            </div>
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
                        <img src="{{ $item['foto'] ? url('storage/' . $item['foto']) : asset('assets/img/defaultbarang.jpg') }}" class="w-10 h-10 rounded-lg shadow">
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
                <div class="mt-4 space-y-3">
                    <dl class="flex flex-col gap-x-3 text-sm">
                        <dt class="text-gray-500">Tanggal Peminjaman:</dt>
                        <input type="date" name="tanggal_peminjaman" id="tanggal_peminjaman" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}">
                    </dl>
                    <dl class="flex flex-col gap-x-3 text-sm">
                        <dt class="text-gray-500">Tanggal Pengembalian:</dt>
                        <input type="date" name="tanggal_pengembalian" id="tanggal_pengembalian" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ date('Y-m-d', strtotime('+7 days')) }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" max="{{ date('Y-m-d', strtotime('+10 days')) }}">
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

            if (tanggalPengembalian.value < tanggalPengembalian.min || tanggalPengembalian.value > tanggalPengembalian.max) {
                tanggalPengembalian.value = tanggalPengembalian.min;
            }
        });
    });
</script>
