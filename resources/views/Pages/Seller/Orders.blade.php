@extends('layout.app2')

@section('title', 'Orders')

@section('content')
    <style>
        /* Status Badge Styles */
        .status-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-paid {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-unpaid {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-pending {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .status-processing {
            background-color: #e0e7ff;
            color: #4338ca;
        }

        .status-approved {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-shipped {
            background-color: #ede9fe;
            color: #6d28d9;
        }

        .status-delivered {
            background-color: #d1fae5;
            color: #047857;
        }

        .status-rejected {
            background-color: #fee2e2;
            color: #b91c1c;
        }

        .status-default {
            background-color: #f3f4f6;
            color: #374151;
        }
    </style>

    <!-- Orders Content Section -->
    <section class="w-full flex justify-center items-start">
        <div class="w-full">
            <!-- Title -->
            <h2 class="text-[2rem] md:text-3xl font-semibold text-gray-800 mb-4">Orders</h2>
            <!-- Row for Total & Filter/Search -->
            @if ($orders->isEmpty())
                <div class="text-center text-gray-700 text-xl font-semibold">
                    No orders found
                </div>
            @else
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                    <div class="flex items-center gap-2 text-xl font-bold text-gray-800">
                        <svg class="w-8 h-8 text-gray-800" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M3 6a1 1 0 011-1h16a1 1 0 110 2H4a1 1 0 01-1-1zm0 5a1 1 0 011-1h16a1 1 0 110 2H4a1 1 0 01-1-1zm1 4a1 1 0 000 2h16a1 1 0 100-2H4z" />
                        </svg>
                        <span class="ml-2">Total - <span class="font-bold">{{ $orders->total() }}</span></span>
                    </div>
                    <div class="flex flex-wrap gap-4 md:gap-2">
                        <form action="{{ route('seller.orders.filter') }}" method="GET">
                            <select name="status" onchange="this.form.submit()"
                                class="border rounded px-4 py-2 bg-white text-gray-700 focus:ring-2 focus:ring-primary-200 shadow-sm text-base font-semibold">
                                <option value="all" {{ isset($status) && $status == 'all' ? 'selected' : '' }}>All
                                </option>
                                <option value="pending" {{ isset($status) && $status == 'pending' ? 'selected' : '' }}>
                                    Pending</option>
                                <option value="processing"
                                    {{ isset($status) && $status == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="approved" {{ isset($status) && $status == 'approved' ? 'selected' : '' }}>
                                    Approved</option>
                                <option value="shipped" {{ isset($status) && $status == 'shipped' ? 'selected' : '' }}>
                                    Shipped</option>
                                <option value="delivered" {{ isset($status) && $status == 'delivered' ? 'selected' : '' }}>
                                    Delivered</option>
                                <option value="rejected" {{ isset($status) && $status == 'rejected' ? 'selected' : '' }}>
                                    Rejected</option>
                            </select>
                        </form>
                        <form action="{{ route('seller.orders.search') }}" method="GET" class="flex" id="searchForm">
                            <div
                                class="flex bg-white rounded overflow-hidden border focus-within:ring-2 focus-within:ring-primary-200">
                                <input type="text" name="search" id="searchInput"
                                    placeholder="Search by username, status, or payment"
                                    value="{{ isset($search) ? $search : '' }}"
                                    class="outline-none px-4 py-2 w-64 text-gray-700 text-sm bg-white" />
                                <button type="submit"
                                    class="px-3 flex items-center justify-center bg-[#222] hover:bg-primary-600 transition">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21 21l-4.35-4.35M15 11a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </button>
                            </div>
                        </form>
                        <a href="{{ route('seller.orders.export') }}"
                            class="bg-[#48ce5e] hover:bg-[#37b44e] transition text-white font-semibold px-6 py-2 rounded shadow flex items-center">
                            CSV DOWNLOAD
                        </a>
                    </div>
                </div>
                <div class="overflow-x-auto rounded-lg shadow table-container">
                    @if ($orders->isEmpty())
                        <div class="text-center py-8">
                            <div class="text-gray-500 text-lg mb-2">
                                Data not found
                            </div>
                            <div class="text-gray-400 text-sm">
                                Try adjusting your search or filter criteria.
                            </div>
                        </div>
                    @else
                        <table class="min-w-full bg-white rounded-lg whitespace-nowrap">
                            <thead>
                                <tr class="text-left text-sm font-bold text-gray-600 border-b">
                                    <th class="py-3 px-4">USER NAME</th>
                                    <th class="py-3 px-4">ORDER DATE</th>
                                    <th class="py-3 px-4">PAYMENT</th>
                                    <th class="py-3 px-4">STATUS</th>
                                    <th class="py-3 px-4">PRODUCTS</th>
                                    <th class="py-3 px-4 text-center">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <!-- Row Start -->
                                    <tr class="border-b hover:bg-gray-50 transition">
                                        <td class="py-4 px-4">{{ $order->user->username }}</td>
                                        <td class="py-4 px-4">
                                            {{ \Carbon\Carbon::parse($order->order_date)->diffForHumans() }}</td>
                                        <td class="py-4 px-4">
                                            @php
                                                $paymentStatus = $order->payments->first()->payment_status ?? '';
                                                $paymentStatusClass = 'status-default';
                                                if ($paymentStatus == 'paid') {
                                                    $paymentStatusClass = 'status-paid';
                                                } elseif ($paymentStatus == 'unpaid') {
                                                    $paymentStatusClass = 'status-unpaid';
                                                }
                                            @endphp
                                            <span class="status-badge {{ $paymentStatusClass }}">
                                                {{ ucfirst($order->payments->first()->method ?? '-') }} -
                                                {{ ucfirst($paymentStatus) }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-4">
                                            @php
                                                $orderStatus = $order->order_status;
                                                $statusClass = 'status-default';
                                                if ($orderStatus == 'pending') {
                                                    $statusClass = 'status-pending';
                                                } elseif ($orderStatus == 'processing') {
                                                    $statusClass = 'status-processing';
                                                } elseif ($orderStatus == 'approved') {
                                                    $statusClass = 'status-approved';
                                                } elseif ($orderStatus == 'shipped') {
                                                    $statusClass = 'status-shipped';
                                                } elseif ($orderStatus == 'delivered') {
                                                    $statusClass = 'status-delivered';
                                                } elseif ($orderStatus == 'rejected') {
                                                    $statusClass = 'status-rejected';
                                                } elseif ($orderStatus == 'cancelled') {
                                                    $statusClass = 'status-rejected';
                                                }
                                            @endphp
                                            <span class="status-badge {{ $statusClass }}">
                                                {{ ucfirst($orderStatus) }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-4">
                                            <div class="relative">
                                                <button
                                                    class="bg-gray-800 btn-order-details text-white text-sm px-4 py-2 rounded font-semibold flex items-center gap-2 shadow"
                                                    data-order='@json($order->order_popup_data)'>
                                                    Details
                                                    <span
                                                        class="bg-red-500 rounded-full px-2 py-0.5 text-xs font-bold ml-2">{{ $order->details->count() }}</span>
                                                </button>
                                            </div>
                                        </td>
                                        <td class="py-4 px-4 flex flex-wrap gap-2 justify-center">
                                            @if ($order->order_status == 'cancelled')
                                                <div class="text-red-600 font-semibold text-sm">Order Cancelled by Customer
                                                </div>
                                            @elseif ($order->order_status == 'processing')
                                                <form action="{{ route('seller.orders.approve', $order->id_order) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        class="bg-green-500 hover:bg-green-600 text-white text-sm px-4 py-2 rounded shadow font-semibold transition flex items-center gap-1">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            stroke-width="2" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M5 13l4 4L19 7" />
                                                        </svg>
                                                        Approve
                                                    </button>
                                                </form>
                                                <button
                                                    class="bg-red-500 hover:bg-red-600 text-white text-sm px-4 py-2 rounded shadow font-semibold transition flex items-center gap-1"
                                                    onclick="showRejectModal('{{ $order->id_order }}')">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                    Reject
                                                </button>
                                            @elseif($order->order_status == 'approved')
                                                <button
                                                    class="bg-purple-500 hover:bg-purple-600 text-white text-sm px-4 py-2 rounded shadow font-semibold transition flex items-center gap-1"
                                                    onclick="showShippingModal('{{ $order->id_order }}')">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                                    </svg>
                                                    Ship Order
                                                </button>
                                            @elseif($order->order_status == 'shipped')
                                                <form action="{{ route('seller.orders.deliver', $order->id_order) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        class="bg-emerald-500 hover:bg-emerald-600 text-white text-sm px-4 py-2 rounded shadow font-semibold transition flex items-center gap-1">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            stroke-width="2" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                        </svg>
                                                        Mark Delivered
                                                    </button>
                                                </form>
                                            @elseif($order->order_status == 'pending')
                                                <div class="text-yellow-600 font-semibold text-sm">Waiting for Payment
                                                </div>
                                            @else
                                                <div class="text-gray-600 font-semibold text-sm">No Actions Available</div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </section>

    <!-- Reject Order Modal -->
    <div id="rejectModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50" style="display: none;">
        <div class="flex items-center justify-center h-full">
            <div class="bg-white rounded-lg p-6 max-w-md w-full shadow-2xl">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Reject Order</h3>
                <form id="rejectForm" action="" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="rejection_reason" class="block text-gray-700 mb-2">Reason for Rejection
                            (Optional)</label>
                        <textarea id="rejection_reason" name="rejection_reason" rows="3"
                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-300"></textarea>
                    </div>
                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="closeRejectModal()"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg font-semibold">
                            Cancel
                        </button>
                        <button type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-semibold">
                            Reject Order
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Shipping Modal -->
    <div id="shippingModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50" style="display: none;">
        <div class="flex items-center justify-center h-full">
            <div class="bg-white rounded-lg p-6 max-w-md w-full shadow-2xl">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Ship Order</h3>
                <form id="shippingForm" action="" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="tracking_number" class="block text-gray-700 mb-2">Tracking Number (Optional)</label>
                        <input type="text" id="tracking_number" name="tracking_number"
                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-300">
                    </div>
                    <div class="mb-4">
                        <label for="shipping_notes" class="block text-gray-700 mb-2">Shipping Notes (Optional)</label>
                        <textarea id="shipping_notes" name="shipping_notes" rows="3"
                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-300"></textarea>
                    </div>
                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="closeShippingModal()"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg font-semibold">
                            Cancel
                        </button>
                        <button type="submit"
                            class="bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-lg font-semibold">
                            Ship Order
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Order Details Modal -->
    <div id="orderDetailsModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg p-6 max-w-lg w-full shadow-2xl">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Order Details</h3>
            <div id="orderDetailsContent"></div>
            <div class="flex justify-end mt-4">
                <button type="button" onclick="closeOrderDetailsModal()"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg font-semibold">
                    Close
                </button>
            </div>
        </div>
    </div>

    <script>
        // Rejection Modal Functions
        function showRejectModal(orderId) {
            document.getElementById('rejectForm').action = `/seller/orders/${orderId}/reject`;
            document.getElementById('rejectModal').style.display = 'flex';
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').style.display = 'none';
        }

        // Shipping Modal Functions
        function showShippingModal(orderId) {
            document.getElementById('shippingForm').action = `/seller/orders/${orderId}/ship`;
            document.getElementById('shippingModal').style.display = 'flex';
        }

        function closeShippingModal() {
            document.getElementById('shippingModal').style.display = 'none';
        }

        // Order Details Modal Functions
        function showOrderDetailsModal(orderData) {
            let html = `
                <div class="mb-2"><strong>Customer:</strong> ${orderData.customer}</div>
                <div class="mb-2"><strong>Order Date:</strong> ${orderData.order_in}</div>
                <div class="mb-2"><strong>Total Amount:</strong> ${orderData.total_amount}</div>
                <div class="mb-2"><strong>Payment Method:</strong> ${orderData.payment_method}</div>
                <div class="mb-2"><strong>Payment Status:</strong> ${orderData.payment_status}</div>
                <div class="mb-2"><strong>Products:</strong>
                    <ul class="list-disc ml-6">
                        ${orderData.products.map(p => `<li>${p.product_name} (x${p.quantity}) - ${p.store_name}</li>`).join('')}
                    </ul>
                </div>
            `;
            document.getElementById('orderDetailsContent').innerHTML = html;
            document.getElementById('orderDetailsModal').classList.remove('hidden');
            document.getElementById('orderDetailsModal').style.display = 'flex';
        }

        function closeOrderDetailsModal() {
            document.getElementById('orderDetailsModal').classList.add('hidden');
            document.getElementById('orderDetailsModal').style.display = 'none';
        }
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-order-details').forEach(btn => {
                btn.addEventListener('click', function() {
                    const orderData = JSON.parse(this.getAttribute('data-order'));
                    showOrderDetailsModal(orderData);
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const searchForm = document.getElementById('searchForm');
            let searchTimeout;

            // Live search functionality
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                const searchTerm = this.value;

                searchTimeout = setTimeout(() => {
                    fetch(`{{ route('seller.orders.search') }}?search=${encodeURIComponent(searchTerm)}`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            // Replace the entire .table-container with the new one
                            const tempDiv = document.createElement('div');
                            tempDiv.innerHTML = data.html;
                            const newTableContainer = tempDiv.querySelector('.table-container');
                            const oldTableContainer = document.querySelector(
                                '.table-container');
                            if (newTableContainer && oldTableContainer) {
                                oldTableContainer.replaceWith(newTableContainer);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                }, 500); // 500ms delay
            });

            // Traditional form submission
            searchForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const searchTerm = searchInput.value;
                window.location.href =
                    `{{ route('seller.orders.search') }}?search=${encodeURIComponent(searchTerm)}`;
            });
        });
    </script>
@endsection
