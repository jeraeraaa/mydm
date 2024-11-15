<x-layout></x-layout>

<div class="w-full pt-24">
    <h2 class="text-xl font-semibold text-gray-800">Konfirmasi Peminjaman</h2>
    @if (session('message'))
        <div class="bg-green-100 text-green-800 p-4 rounded-lg mb-6 text-center">
            {{ session('message') }}
        </div>
    @endif

    <!-- Tampilkan item yang dipilih -->
    <table class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr>
                <th class="p-6 text-start">Produk</th>
                <th class="p-6 text-start">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($selectedCart as $id => $item)
                <tr>
                    <td class="p-6 flex items-center gap-4">
                        <img src="{{ $item['foto'] ? url('storage/' . $item['foto']) : asset('assets/img/defaultbarang.jpg') }}"
                            alt="{{ $item['name'] }}" class="w-16 h-16 rounded-lg shadow">
                        <span class="text-gray-800 font-semibold">{{ $item['name'] }}</span>
                    </td>
                    <td class="p-6">{{ $item['jumlah'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Tombol Final Checkout -->
    <form action="{{ route('alat.frontend.checkout') }}" method="POST" class="mt-4">
        @csrf
        <button type="submit" class="py-2 px-4 bg-green-500 text-white rounded-lg hover:bg-green-600">
            Ajukan Peminjaman
        </button>
    </form>
</div>
