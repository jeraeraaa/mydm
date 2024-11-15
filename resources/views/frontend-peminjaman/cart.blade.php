<x-layout></x-layout>

<div class="w-full pt-24">
    <!-- Display Flash Message -->
    @if (session('message'))
        <div class="bg-green-100 text-green-800 p-4 rounded-lg mb-6 text-center">
            {{ session('message') }}
        </div>
    @endif

    <!-- Detailed Cart Section -->
    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <div class="flex flex-col">
            <div class="-m-1.5 overflow-x-auto">
                <div class="p-1.5 min-w-full inline-block align-middle">
                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-800">Keranjang Anda</h2>
                        </div>

                        <!-- Cart Table -->
                        <form id="cart-form" action="{{ route('alat.frontend.confirmLoan') }}" method="POST">
                            @csrf
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="p-6 text-start">
                                            <input type="checkbox" class="rounded text-blue-600 focus:ring-blue-500"
                                                id="selectAll">
                                        </th>
                                        <th class="p-6 text-start">Produk</th>
                                        <th class="p-6 text-start">Jumlah</th>
                                        <th class="p-6 text-start">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($cart as $id => $item)
                                        <tr data-id="{{ $id }}">
                                            <td class="p-6">
                                                <input type="checkbox"
                                                    class="rounded text-blue-600 focus:ring-blue-500 item-checkbox"
                                                    name="selectedItems[]" value="{{ $id }}">
                                            </td>
                                            <td class="p-6 flex items-center gap-4">
                                                <img src="{{ $item['foto'] ? url('storage/' . $item['foto']) : asset('assets/img/defaultbarang.jpg') }}"
                                                    alt="{{ $item['name'] }}" class="w-16 h-16 rounded-lg shadow">
                                                <span class="text-gray-800 font-semibold">{{ $item['name'] }}</span>
                                            </td>
                                            <td class="p-6">
                                                <div class="flex items-center">
                                                    <!-- Tombol decrement dengan font lebih besar dan padding -->
                                                    {{-- <button type="button"
                                                        class="p-2 bg-gray-200 rounded text-lg font-bold"
                                                        onclick="updateCartQuantity('{{ $id }}', 'decrement')">-</button> --}}

                                                    <!-- Input jumlah dengan ukuran lebih besar dan tanpa tanda panah -->
                                                    <input type="number" min="1"
                                                        class="mx-2 w-16 text-center border rounded text-lg font-semibold"
                                                        value="{{ $item['jumlah'] }}" id="quantity-{{ $id }}"
                                                        onchange="manualUpdateCartQuantity('{{ $id }}')"
                                                        style="appearance: none; -moz-appearance: textfield;">

                                                    {{-- <!-- Tombol increment dengan font lebih besar dan padding -->
                                                    <button type="button"
                                                        class="p-2 bg-gray-200 rounded text-lg font-bold"
                                                        onclick="updateCartQuantity('{{ $id }}', 'increment')">+</button> --}}
                                                </div>
                                            </td>

                                            <td class="p-6">
                                                <!-- Button untuk Hapus dengan JavaScript -->
                                                <button type="button" onclick="removeFromCart('{{ $id }}')"
                                                    class="text-red-500 hover:underline">Hapus</button>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>

                            <!-- Checkout Button di form yang sama -->
                            <div class="p-6 border-t border-gray-200 flex justify-end">
                                <button type="submit"
                                    class="py-2 px-4 bg-orange-500 text-white rounded-lg hover:bg-orange-600">
                                    Checkout
                                </button>
                            </div>
                        </form>
                        <!-- End Cart Table -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Cart Management -->
<script>
    // Select All function
    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.item-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // Function to remove item from cart with AJAX
    function removeFromCart(id) {
        if (!confirm('Apakah Anda yakin ingin menghapus item ini dari keranjang?')) return;

        fetch(`{{ url('/frontend-peminjaman/cart/remove') }}/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.querySelector(`tr[data-id='${id}']`).remove();
                } else {
                    alert('Gagal menghapus item dari keranjang.');
                }
            })
            .catch(error => console.error('Error:', error));
    }

    // Function to update quantity in cart with AJAX
    // function updateCartQuantity(id, action) {
    //     fetch(`{{ url('/frontend-peminjaman/alat/update-quantity') }}/${id}`, {
    //             method: 'POST',
    //             headers: {
    //                 'X-CSRF-TOKEN': '{{ csrf_token() }}',
    //                 'Content-Type': 'application/json'
    //             },
    //             body: JSON.stringify({
    //                 action: action
    //             })
    //         })
    //         .then(response => response.json())
    //         .then(data => {
    //             if (data.success) {
    //                 document.getElementById(`quantity-${id}`).value = data.newQuantity;
    //             }
    //         })
    //         .catch(error => console.error('Error:', error));
    // }

    // Function to manually update quantity from the input
    function manualUpdateCartQuantity(id) {
        const quantity = document.getElementById(`quantity-${id}`).value;

        fetch(`{{ url('/frontend-peminjaman/alat/update-quantity') }}/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    action: 'manual',
                    quantity: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    alert('Jumlah yang dimasukkan melebihi jumlah tersedia.');
                    document.getElementById(`quantity-${id}`).value = data.maxAvailable;
                }
            })
            .catch(error => console.error('Error:', error));
    }
</script>
