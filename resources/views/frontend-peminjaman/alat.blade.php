<x-layout></x-layout>

<div class="w-full pt-32">
    <!-- Bagian Sambutan -->
    <div class="bg-white rounded-lg p-6 text-center mb-8">
        <h1 class="text-balance text-2xl font-bold tracking-tight text-gray-800 sm:text-3xl lg:text-4xl mb-6">Selamat
            Datang di Fitur Peminjaman Alat</h1>
        <p class="text-gray-600">Butuh perlengkapan untuk mendukung proker/kegiatanmu? Temukan berbagai macam alat yang
            tersedia di sini!</p>
        <p class="mt-2 text-gray-500">Pilih divisi yang sesuai untuk melihat alat yang dapat dipinjam, atau gunakan
            filter untuk menemukan alat tertentu.</p>
    </div>

    <!-- Konten utama halaman -->
    <div x-data="{ selectedDivisi: 'All' }" class="flex flex-col bg-white border shadow-sm rounded-xl">

        <!-- Select untuk Mobile (Dinamis dari Bph) -->
        <div class="sm:hidden">
            <label for="divisi-filter-mobile" class="sr-only">Select a Division</label>
            <select id="divisi-filter-mobile"
                class="block w-full border-gray-300 rounded-t-xl focus:border-orange-500 focus:ring-orange-500"
                x-model="selectedDivisi">
                <option value="All">All</option>
                @foreach ($divisi as $d)
                    <option value="{{ $d->id_bph }}">{{ $d->nama_divisi_bph }}</option>
                @endforeach
            </select>
        </div>
        <!-- End Select (Mobile) -->

        <!-- Nav untuk Device yang Lebih Besar (Dinamis dari Bph) -->
        <div class="hidden sm:block">
            <nav class="relative z-0 flex border-b divide-x divide-gray-200 rounded-xl">
                <button @click="selectedDivisi = 'All'"
                    :class="{ 'border-b-2 border-orange-500 text-black': selectedDivisi === 'All', 'text-gray-500': selectedDivisi !== 'All' }"
                    class="group relative min-w-0 flex-1 bg-white py-4 px-4 text-sm font-medium text-center hover:bg-gray-50 focus:outline-none">
                    All
                </button>
                @foreach ($divisi as $d)
                    <button @click="selectedDivisi = '{{ $d->id_bph }}'"
                        :class="{ 'border-b-2 border-orange-500 text-black': selectedDivisi === '{{ $d->id_bph }}', 'text-gray-500': selectedDivisi !== '{{ $d->id_bph }}' }"
                        class="group relative min-w-0 flex-1 bg-white py-4 px-4 text-sm font-medium text-center hover:bg-gray-50 focus:outline-none">
                        {{ $d->nama_divisi_bph }}
                    </button>
                @endforeach
            </nav>
        </div>
        <!-- End Nav untuk Device yang Lebih Besar -->

        <!-- Konten Daftar Alat -->
        <div class="p-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <template
                x-if="selectedDivisi === 'All' ? ({{ $alat->total() }} === 0) : (Array.from(document.querySelectorAll('[data-divisi]')).filter(el => el.getAttribute('data-divisi') === selectedDivisi).length === 0)">
                <div class="col-span-full text-center text-gray-500 font-semibold">
                    Tidak ada alat yang tersedia di divisi ini.
                </div>
            </template>

            <!-- Blade Template for Alat Cards -->
            @foreach ($alat as $item)
                @php
                    $inCart = session('cart') && isset(session('cart')[$item->id_alat]); // Cek apakah item sudah ada di keranjang
                @endphp
                <div x-show="selectedDivisi === 'All' || selectedDivisi === '{{ $item->id_bph }}'"
                    data-divisi="{{ $item->id_bph }}" data-in-cart="{{ $inCart ? 'true' : 'false' }}"
                    id="alat-{{ $item->id_alat }}"
                    class="flex flex-col bg-white border shadow-sm rounded-lg overflow-hidden">
                    <img src="{{ $item->foto ? url('storage/' . $item->foto) : asset('assets/img/defaultbarang.jpg') }}"
                        alt="Foto Alat" class="h-40 object-cover">
                    <div class="p-4 text-center">
                        <h5 class="text-lg font-bold text-gray-800">{{ $item->nama_alat }}</h5>
                        <p class="mt-2 text-gray-500 h-16 overflow-hidden">
                            {{ \Illuminate\Support\Str::limit($item->deskripsi, 60) }}
                        </p>
                        <div class="flex justify-between items-center mt-4">
                            <!-- Form for Add to Cart -->
                            <form action="{{ route('alat.frontend.addToCart', $item->id_alat) }}" method="POST"
                                class="add-to-cart-form" data-id="{{ $item->id_alat }}">
                                @csrf
                                <input type="hidden" name="jumlah" value="1">
                                <button type="submit" id="add-to-cart-btn-{{ $item->id_alat }}"
                                    style="{{ $inCart ? 'display: none;' : '' }}">
                                    <img src="{{ asset('assets/img/cart.png') }}" alt="Add to Cart" class="h-8 w-8">
                                </button>
                            </form>
                            <span id="in-cart-label-{{ $item->id_alat }}"
                                style="{{ $inCart ? '' : 'display: none;' }}"
                                class="text-green-500 font-semibold">Sudah di Keranjang</span>
                            <a href="{{ route('alat.frontend.show', $item->id_alat) }}"
                                class="px-3 py-2 bg-gray-400 text-white rounded-lg hover:bg-orange-600 transition">
                                Detail
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach


        </div>

    </div>

    <!-- Pagination dengan Informasi -->
    <div class="mt-6 flex flex-col items-center">
        <!-- Informasi Showing Results -->
        <div class="text-gray-500 text-sm mb-4">
            Showing {{ $alat->firstItem() }} to {{ $alat->lastItem() }} of {{ $alat->total() }} results
        </div>

        <!-- Tombol Pagination -->
        <nav class="flex items-center gap-x-1" aria-label="Pagination">
            <!-- Tombol Previous -->
            @if ($alat->onFirstPage())
                <button
                    class="min-h-[38px] min-w-[38px] py-2 px-2.5 inline-flex justify-center items-center gap-x-2 text-sm rounded-lg text-gray-300"
                    disabled aria-label="Previous">
                    <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="m15 18-6-6 6-6"></path>
                    </svg>
                    <span class="sr-only">Previous</span>
                </button>
            @else
                <a href="{{ $alat->previousPageUrl() }}"
                    class="min-h-[38px] min-w-[38px] py-2 px-2.5 inline-flex justify-center items-center gap-x-2 text-sm rounded-lg text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                    aria-label="Previous">
                    <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="m15 18-6-6 6-6"></path>
                    </svg>
                    <span class="sr-only">Previous</span>
                </a>
            @endif

            <!-- Informasi Halaman -->
            <div class="flex items-center gap-x-1">
                <span
                    class="min-h-[38px] min-w-[38px] flex justify-center items-center border border-gray-200 text-gray-800 py-2 px-3 text-sm rounded-lg">{{ $alat->currentPage() }}</span>
                <span class="min-h-[38px] flex justify-center items-center text-gray-500 py-2 px-1.5 text-sm">of</span>
                <span
                    class="min-h-[38px] flex justify-center items-center text-gray-500 py-2 px-1.5 text-sm">{{ $alat->lastPage() }}</span>
            </div>

            <!-- Tombol Next -->
            @if ($alat->hasMorePages())
                <a href="{{ $alat->nextPageUrl() }}"
                    class="min-h-[38px] min-w-[38px] py-2 px-2.5 inline-flex justify-center items-center gap-x-2 text-sm rounded-lg text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                    aria-label="Next">
                    <span class="sr-only">Next</span>
                    <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="m9 18 6-6-6-6"></path>
                    </svg>
                </a>
            @else
                <button
                    class="min-h-[38px] min-w-[38px] py-2 px-2.5 inline-flex justify-center items-center gap-x-2 text-sm rounded-lg text-gray-300"
                    disabled aria-label="Next">
                    <span class="sr-only">Next</span>
                    <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="m9 18 6-6-6-6"></path>
                    </svg>
                </button>
            @endif
        </nav>
    </div>
    <!-- End Pagination -->
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
                        cartCountElement.textContent = data.cartCount;

                        // Ubah tampilan tombol menjadi "Sudah di Keranjang"
                        document.getElementById(`add-to-cart-btn-${itemId}`).style.display = 'none';
                        document.getElementById(`in-cart-label-${itemId}`).style.display = 'inline';
                    } else {
                        alert(data.message || 'Gagal menambah ke keranjang.');
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        });
    });
</script>

