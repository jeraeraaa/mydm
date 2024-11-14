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
                        <form id="cart-form" action="{{ route('alat.frontend.checkoutSelected') }}" method="POST">
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
                                        <tr>
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
                                                    <button type="button" class="p-1 bg-gray-200 rounded"
                                                        onclick="updateCartQuantity({{ $id }}, 'decrement')">-</button>
                                                    <input type="number" min="1"
                                                        class="mx-2 w-12 text-center border rounded"
                                                        value="{{ $item['jumlah'] }}" id="quantity-{{ $id }}"
                                                        readonly>
                                                    <button type="button" class="p-1 bg-gray-200 rounded"
                                                        onclick="updateCartQuantity({{ $id }}, 'increment')">+</button>
                                                </div>
                                            </td>
                                            <td class="p-6">
                                                <button type="button" class="text-red-500 hover:underline"
                                                    onclick="removeFromCart({{ $id }})">Hapus</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </form>
                        <!-- End Cart Table -->

                        <!-- Checkout Button -->
                        <div class="p-6 border-t border-gray-200 flex justify-end">
                            <button type="button"
                                class="py-2 px-4 bg-orange-500 text-white rounded-lg hover:bg-orange-600"
                                onclick="checkoutSelected()">Checkout Selected</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Cart Management -->
<script>
    // Update quantity function
    function updateCartQuantity(id, action) {
        let qtyInput = document.getElementById(`quantity-${id}`);
        let newQty = parseInt(qtyInput.value);

        if (action === 'increment') {
            newQty += 1;
        } else if (action === 'decrement' && newQty > 1) {
            newQty -= 1;
        }

        qtyInput.value = newQty;

        fetch(`/frontend-peminjaman/alat/update-quantity/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                quantity: newQty
            })
        }).then(response => response.json()).then(data => {
            if (data.success) {
                // Update cart count if needed
                const cartCountElement = document.getElementById('cart-count');
                cartCountElement.textContent = data.cartCount;
            } else {
                alert('Gagal memperbarui jumlah item.');
            }
        }).catch(error => {
            console.error('Error:', error);
        });
    }

    // Remove item from cart function
    function removeFromCart(id) {
        fetch(`/frontend-peminjaman/cart/remove/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            }
        }).then(response => response.json()).then(data => {
            if (data.success) {
                location.reload(); // Reload page to show updated cart
            } else {
                alert('Gagal menghapus item dari keranjang.');
            }
        }).catch(error => {
            console.error('Error:', error);
        });
    }

    // Select All function
    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.item-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // Checkout selected items function
    function checkoutSelected() {
        const form = document.getElementById('cart-form');
        const selectedItems = document.querySelectorAll('.item-checkbox:checked');

        if (selectedItems.length > 0) {
            form.submit();
        } else {
            alert('Pilih item yang ingin di-checkout.');
        }
    }
</script>
