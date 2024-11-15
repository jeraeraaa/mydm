<!-- resources/views/frontend-peminjaman/checkout-confirmation.blade.php -->
<x-layout></x-layout>

<div class="w-full pt-24">
    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden p-6">
            <h2 class="text-2xl font-semibold text-gray-800">Checkout Berhasil</h2>
            <p class="mt-4 text-gray-600">Terima kasih telah melakukan peminjaman alat. Detail peminjaman Anda akan
                segera diproses.</p>
            <a href="{{ route('alat.frontend') }}"
                class="mt-6 inline-block py-2 px-4 bg-orange-500 text-white rounded-lg hover:bg-orange-600">Kembali ke
                Daftar Alat</a>
        </div>
    </div>
</div>
