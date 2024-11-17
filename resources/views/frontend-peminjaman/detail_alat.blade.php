<x-layout></x-layout>

<div class="w-full pt-32">
    <div class="container mx-auto px-4">
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="bg-gray-100 px-6 py-4 border-b">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-semibold text-gray-800">{{ $alat->nama_alat }}</h2>
                        <p class="text-sm text-gray-600">Detail lengkap dari alat</p>
                    </div>
                    <a href="{{ route('alat.frontend') }}"
                        class="text-orange-500 hover:text-orange-700 text-sm font-semibold flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali
                    </a>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Image Section -->
                    <div class="flex justify-center">
                        <img src="{{ $alat->foto ? url('storage/' . $alat->foto) : asset('assets/img/defaultbarang.jpg') }}"
                            alt="Foto Alat" class="rounded-lg shadow-md object-cover w-full h-64">
                    </div>

                    <!-- Details Section -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Alat</h3>
                        <p class="text-sm text-gray-800 mb-2"><strong>Nama Alat:</strong> {{ $alat->nama_alat }}</p>
                        <p class="text-sm text-gray-800 mb-2"><strong>Deskripsi:</strong>
                            {{ $alat->deskripsi ?? 'Tidak ada Deskripsi' }}</p>
                        <p class="text-sm text-gray-800 mb-2"><strong>Jumlah Tersedia:</strong>
                            {{ $alat->jumlah_tersedia }}</p>
                        <p class="text-sm text-gray-800 mb-2"><strong>Status:</strong>
                            @if ($alat->status_alat == 'A')
                                Ada
                            @elseif($alat->status_alat == 'P')
                                Sedang Dipinjam
                            @else
                                Rusak
                            @endif
                        </p>
                        <p class="text-sm text-gray-800"><strong>Divisi BPH:</strong>
                            {{ $alat->bph->nama_divisi_bph ?? 'Tidak ada Divisi' }}</p>
                        <!-- Form for Add to Cart in detail_alat.blade -->
                        @php
                            $inCart = session('cart') && isset(session('cart')[$alat->id_alat]); // Cek apakah item sudah ada di keranjang
                        @endphp

                        @if (session('message'))
                            <div class="text-green-500 font-semibold mb-4">
                                {{ session('message') }}
                            </div>
                        @endif

                        @if (!$inCart)
                            <form action="{{ route('alat.frontend.addToCart', $alat->id_alat) }}" method="POST"
                                class="add-to-cart-form" data-id="{{ $alat->id_alat }}">
                                @csrf
                                <input type="hidden" name="jumlah" value="1">
                                <button type="submit" id="add-to-cart-btn-{{ $alat->id_alat }}">
                                    <img src="{{ asset('assets/img/cart.png') }}" alt="Add to Cart" class="h-8 w-8">
                                </button>
                            </form>
                        @else
                            <span id="in-cart-label-{{ $alat->id_alat }}" class="text-green-500 font-semibold">Sudah di
                                Keranjang</span>
                        @endif

                    </div>
                </div>

                <!-- Riwayat Peminjaman -->
                <div class="mt-6">
                    <hr class="my-4">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Riwayat Peminjaman</h3>
                    @if ($alat->detailPeminjaman->isEmpty())
                        <p class="text-sm text-gray-500">Belum ada riwayat peminjaman untuk alat ini.</p>
                    @else
                    <table class="w-full text-sm text-left text-gray-700 border border-collapse">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="py-3 px-6 text-center text-xs font-medium text-gray-600 uppercase tracking-wider border">
                                    Peminjam
                                </th>
                                <th class="py-3 px-6 text-center text-xs font-medium text-gray-600 uppercase tracking-wider border">
                                    Tanggal Pinjam
                                </th>
                                <th class="py-3 px-6 text-center text-xs font-medium text-gray-600 uppercase tracking-wider border">
                                    Tanggal Kembali
                                </th>
                                <th class="py-3 px-6 text-center text-xs font-medium text-gray-600 uppercase tracking-wider border">
                                    Kondisi Dipinjam
                                </th>
                                <th class="py-3 px-6 text-center text-xs font-medium text-gray-600 uppercase tracking-wider border">
                                    Kondisi Dikembalikan
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($alat->detailPeminjaman as $peminjaman)
                                <tr class="hover:bg-gray-100">
                                    <td class="py-3 px-6 text-center text-gray-800 border">
                                        {{ $peminjaman->nama_peminjam ?? 'Tidak Diketahui' }}
                                    </td>
                                    <td class="py-3 px-6 text-center text-gray-800 border">
                                        {{ $peminjaman->tanggal_pinjam ? \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d/m/Y') : '-' }}
                                    </td>
                                    <td class="py-3 px-6 text-center text-gray-800 border">
                                        {{ $peminjaman->tanggal_kembali ? \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d/m/Y') : 'Belum Dikembalikan' }}
                                    </td>
                                    <td class="py-3 px-6 text-center text-gray-800 border">
                                        {{ $peminjaman->kondisi_alat_dipinjam ?? 'Tidak Ada Data' }}
                                    </td>
                                    <td class="py-3 px-6 text-center text-gray-800 border">
                                        {{ $peminjaman->kondisi_setelah_dikembalikan ?? 'Belum Dikembalikan' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-3 px-6 text-center text-gray-500 border">
                                        Belum ada riwayat peminjaman untuk alat ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('.add-to-cart-form');

        forms.forEach(form => {
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                const itemId = form.getAttribute('data-id');
                const formData = new FormData(form);

                fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log("Response dari server:", data);
                        if (data.success) {
                            // Update jumlah item di cart-count
                            const cartCountElement = document.getElementById('cart-count');
                            if (cartCountElement) {
                                cartCountElement.textContent = data.cartCount;
                            }

                            // Ubah tampilan tombol menjadi "Sudah di Keranjang"
                            document.getElementById(`add-to-cart-btn-${itemId}`).style
                                .display = 'none';
                            document.getElementById(`in-cart-label-${itemId}`).style
                                .display = 'inline';
                        } else {
                            alert(data.message || 'Gagal menambah ke keranjang.');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    });
</script>
