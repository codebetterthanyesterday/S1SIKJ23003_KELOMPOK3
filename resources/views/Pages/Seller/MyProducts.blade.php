@extends('layout.app2')

@section('title', 'My Products')

@section('content')
    <div class="bg-[#fbfbfb] w-full p-7 rounded-lg shadow-md border-[1px] border-[#eeeeee] mt-10">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Product Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Category
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Price
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Stock
                        </th>

                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr
                            class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $product->product_name }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $product->category->category_name ?? 'No category' }}
                            </td>
                            <td class="px-6 py-4">
                                Rp{{ number_format($product->price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $product->stock ?? 0 }}
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('seller.product.show', $product->id_product) }}"
                                    class="text-blue-600 hover:underline mr-2">Detail</a>
                                <a href="{{ route('seller.product.edit', $product->id_product) }}"
                                    class="text-orange-600 hover:underline mr-2">Edit</a>
                                <form action="{{ route('seller.product.destroy', $product->id_product) }}" method="POST"
                                    class="inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="text-red-600 hover:underline delete-btn">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                No products found. <a href="{{ route('seller.creation', 'product') }}"
                                    class="text-blue-600 hover:underline">Create your first product</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
    <!-- Modal Dialog -->
    <div id="product-modal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl p-6 max-w-md w-full relative shadow-lg">
            <button id="close-modal"
                class="absolute top-3 right-3 text-gray-400 hover:text-red-600 text-2xl">&times;</button>
            <div id="modal-content"></div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Show Detail Modal
            document.querySelectorAll('.view-detail-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const product = JSON.parse(this.dataset.product);
                    const category = this.dataset.category;
                    document.getElementById('modal-content').innerHTML = `
                <h3 class="text-xl font-bold mb-2">Product Detail</h3>
                <ul class="mb-2">
                    <li><b>Name:</b> ${product.product_name}</li>
                    <li><b>Category:</b> ${category}</li>
                    <li><b>Price:</b> Rp${parseInt(product.price).toLocaleString('id-ID')}</li>
                    <li><b>Stock:</b> ${product.stock}</li>
                    <li><b>Description:</b> ${product.description || '-'}</li>
                </ul>
            `;
                    showModal();
                });
            });

            // Show Edit Modal
            document.querySelectorAll('.edit-product-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const product = JSON.parse(this.dataset.product);
                    const category = this.dataset.category;
                    document.getElementById('modal-content').innerHTML = `
                <h3 class="text-xl font-bold mb-2">Edit Product</h3>
                <form action="/seller/products/${product.product_id}" method="POST" enctype="multipart/form-data" class="space-y-3">
                    @csrf
                    @method('PUT')
                    <label class="block">
                        Name
                        <input type="text" name="product_name" class="block w-full border p-1 rounded" value="${product.product_name}" required>
                    </label>
                    <label class="block">
                        Price
                        <input type="number" name="price" class="block w-full border p-1 rounded" value="${product.price}" min="0" required>
                    </label>
                    <label class="block">
                        Stock
                        <input type="number" name="stock" class="block w-full border p-1 rounded" value="${product.stock}" min="0" required>
                    </label>
                    <label class="block">
                        Description
                        <textarea name="description" class="block w-full border p-1 rounded" rows="3">${product.description || ''}</textarea>
                    </label>
                    <div class="flex gap-2 justify-end mt-3">
                        <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded">Save</button>
                        <button type="button" id="cancel-edit" class="bg-gray-300 text-gray-800 px-3 py-1 rounded">Cancel</button>
                    </div>
                </form>
            `;
                    showModal();

                    // Cancel Edit
                    document.getElementById('cancel-edit').onclick = hideModal;
                });
            });

            // Delete Confirmation
            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    Swal.fire({
                        title: 'Delete Product?',
                        text: "This action cannot be undone!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#e3342f',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, delete'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            btn.closest('form').submit();
                        }
                    });
                });
            });

            // Modal show/hide helpers
            function showModal() {
                document.getElementById('product-modal').classList.remove('hidden');
            }

            function hideModal() {
                document.getElementById('product-modal').classList.add('hidden');
                document.getElementById('modal-content').innerHTML = '';
            }
            document.getElementById('close-modal').onclick = hideModal;

            // Hide modal if click outside content
            document.getElementById('product-modal').addEventListener('mousedown', function(e) {
                if (e.target === this) hideModal();
            });
        });
    </script>
@endpush
