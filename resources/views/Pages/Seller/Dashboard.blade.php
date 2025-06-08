@extends('layout.app2')

@section('title', 'Dashboard')

@section('content')
    {{-- Totals are passed from controller --}}

    <div class="flex flex-col flex-wrap md:flex-row gap-6 items-start">
        <!-- Total Products Card -->
        <div class="relative flex-1 min-w-[250px] expandable-card transition-transform transform hover:-translate-y-1 hover:shadow-xl"
            data-metric="products">
            <button type="button" class="absolute top-2 right-2 z-10 toggle-expand-btn p-1 rounded hover:bg-gray-100"
                data-metric="products" aria-label="Toggle details">
                <svg class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div
                class="absolute -top-4 left-4 w-12 h-12 rounded-lg shadow-lg bg-purple-500 flex items-center justify-center text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M3 12h18M3 17h18" />
                </svg>
            </div>
            <div class="bg-white rounded-lg shadow p-6 pt-10 flex flex-col">
                <div class="text-sm text-gray-500">Total Products</div>
                <div class="mt-1 text-2xl font-bold text-gray-800"><span id="products-total-count"
                        data-count="{{ $totalProducts }}">{{ $totalProducts }}</span></div>
                <!-- Footer percentage change -->
                <div id="products-footer-change" class="mt-2 text-sm"></div>
                <div class="expandable-content hidden mt-4 text-sm text-gray-700">
                    <div class="flex justify-between">
                        <span>This Month:</span>
                        <span id="products-this-month">-</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Last Month:</span>
                        <span id="products-last-month">-</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Revenue Card -->
        <div class="relative flex-1 min-w-[250px] expandable-card transition-transform transform hover:-translate-y-1 hover:shadow-xl"
            data-metric="revenue">
            <button type="button" class="absolute top-2 right-2 z-10 toggle-expand-btn p-1 rounded hover:bg-gray-100"
                data-metric="revenue" aria-label="Toggle details">
                <svg class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div
                class="absolute -top-4 left-4 w-12 h-12 rounded-lg shadow-lg bg-green-600 flex items-center justify-center text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8v2m0 4v2" />
                </svg>
            </div>
            <div class="bg-white rounded-lg shadow p-6 pt-10 flex flex-col">
                <div class="text-sm text-gray-500">Total Revenue</div>
                <div class="mt-1 text-2xl font-bold text-gray-800">Rp<span id="revenue-total-count"
                        data-count="{{ $totalRevenue }}">{{ number_format($totalRevenue, 0, ',', '.') }}</span></div>
                <!-- Footer percentage change -->
                <div id="revenue-footer-change" class="mt-2 text-sm"></div>
                <div class="expandable-content hidden mt-4 text-sm text-gray-700">
                    <div class="flex justify-between">
                        <span>This Month:</span>
                        <span id="revenue-this-month">-</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Last Month:</span>
                        <span id="revenue-last-month">-</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Stores Card -->
        <div class="relative flex-1 min-w-[250px] expandable-card transition-transform transform hover:-translate-y-1 hover:shadow-xl"
            data-metric="stores">
            <button type="button" class="absolute top-2 right-2 z-10 toggle-expand-btn p-1 rounded hover:bg-gray-100"
                data-metric="stores" aria-label="Toggle details">
                <svg class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div
                class="absolute -top-4 left-4 w-12 h-12 rounded-lg shadow-lg bg-red-500 flex items-center justify-center text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="bg-white rounded-lg shadow p-6 pt-10 flex flex-col">
                <div class="text-sm text-gray-500">Total Stores</div>
                <div class="mt-1 text-2xl font-bold text-gray-800"><span id="stores-total-count"
                        data-count="{{ $totalStores }}">{{ $totalStores }}</span></div>
                <!-- Footer percentage change -->
                <div id="stores-footer-change" class="mt-2 text-sm"></div>
                <div class="expandable-content hidden mt-4 text-sm text-gray-700">
                    <div class="flex justify-between">
                        <span>This Month:</span>
                        <span id="stores-this-month">-</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Last Month:</span>
                        <span id="stores-last-month">-</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Low Stock Card -->
        <div
            class="relative flex-1 min-w-[250px] transition-transform transform hover:-translate-y-1 hover:shadow-xl expandable-card bg-yellow-50 rounded-lg">
            <div
                class="absolute -top-4 left-4 w-12 h-12 rounded-lg shadow-lg bg-yellow-400 flex items-center justify-center text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="bg-white rounded-lg shadow p-6 pt-10 flex flex-col">
                <div class="text-sm text-gray-500">Low Stock (&le;5)</div>
                <div class="mt-1 text-2xl font-bold text-gray-800"><span id="lowstock-total"
                        data-count="{{ $lowStockProducts }}">{{ $lowStockProducts }}</span> <span
                        class="text-sm text-gray-600">({{ $totalProducts == 0 ? 0 : round(($lowStockProducts / $totalProducts) * 100, 1) }}%)</span>
                </div>
            </div>
        </div>

        <!-- Out of Stock Card -->
        <div
            class="relative flex-1 min-w-[250px] transition-transform transform hover:-translate-y-1 hover:shadow-xl expandable-card bg-red-50 rounded-lg">
            <div
                class="absolute -top-4 left-4 w-12 h-12 rounded-lg shadow-lg bg-red-500 flex items-center justify-center text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M18.364 5.636l-1.414 1.414M6.343 17.657l-1.414-1.414M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="bg-white rounded-lg shadow p-6 pt-10 flex flex-col">
                <div class="text-sm text-gray-500">Out of Stock</div>
                <div class="mt-1 text-2xl font-bold text-gray-800"><span id="nostock-total"
                        data-count="{{ $outOfStockProducts }}">0</span> <span
                        class="text-sm text-gray-600">({{ $totalProducts == 0 ? 0 : round(($outOfStockProducts / $totalProducts) * 100, 1) }}%)</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Section -->
    <div class="mt-10">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h2>
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('seller.creation', 'product') }}"
                class="flex items-center px-5 py-3 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-600 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Add New Product
            </a>
            <a href="{{ route('seller.orders.index') }}"
                class="flex items-center px-5 py-3 bg-green-500 text-white rounded-lg shadow hover:bg-green-600 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 8l1.5 12a2 2 0 002 2h7a2 2 0 002-2L21 8H5z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 8V6a4 4 0 00-8 0v2" />
                </svg>
                View Orders
            </a>
            <a href="{{ route('seller.products.list') }}"
                class="flex items-center px-5 py-3 bg-purple-500 text-white rounded-lg shadow hover:bg-purple-600 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M3 12h18M3 17h18" />
                </svg>
                My Products
            </a>
            <a href="{{ route('seller.stores.list') }}"
                class="flex items-center px-5 py-3 bg-yellow-500 text-white rounded-lg shadow hover:bg-yellow-600 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 7l9-4 9 4v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 21V9h6v12" />
                </svg>
                My Stores
            </a>
            <a href="{{ route('seller.creation', 'store') }}"
                class="flex items-center px-5 py-3 bg-orange-500 text-white rounded-lg shadow hover:bg-orange-600 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="7" width="18" height="10" rx="2" stroke="currentColor" stroke-width="2" fill="none"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v4m2-2h-4" />
                </svg>
                Add Store
            </a>
        </div>
    </div>

    <!-- Sales Trend Chart -->
    <div class="mt-10">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Sales Trend</h2>
        <canvas id="salesChart" height="100"></canvas>
    </div>

    <!-- Recent Orders Table -->
    <div class="mt-10">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Recent Orders</h2>
        <div id="ordersTableWrapper">
            <table class="min-w-full bg-white rounded-lg shadow overflow-hidden">
                <thead>
                    <tr>
                        <th class="px-4 py-2">Order ID</th>
                        <th class="px-4 py-2">Customer</th>
                        <th class="px-4 py-2">Amount</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Date</th>
                    </tr>
                </thead>
                <tbody id="ordersTableBody">
                    <tr>
                        <td colspan="5" class="text-center py-4">Loading...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Chart.js & AJAX Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/countup.js/2.0.8/countUp.min.js"></script>
    <script>
        // Fetch sales data for the chart
        fetch("{{ route('seller.dashboard.salesdata') }}")
            .then(response => response.json())
            .then(data => {
                const ctx = document.getElementById('salesChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Sales',
                            data: data.sales,
                            backgroundColor: 'rgba(99, 102, 241, 0.2)',
                            borderColor: 'rgba(99, 102, 241, 1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            });

        // Fetch recent orders for the table
        function loadRecentOrders() {
            fetch("{{ route('seller.dashboard.recentorders') }}")
                .then(response => response.json())
                .then(data => {
                    const tbody = document.getElementById('ordersTableBody');
                    tbody.innerHTML = '';
                    if (data.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="5" class="text-center py-4">No recent orders.</td></tr>';
                        return;
                    }
                    data.forEach(order => {
                        tbody.innerHTML += `
                            <tr>
                                <td class="px-4 py-2">${order.id}</td>
                                <td class="px-4 py-2">${order.customer}</td>
                                <td class="px-4 py-2">Rp${order.amount.toLocaleString('id-ID')}</td>
                                <td class="px-4 py-2">${order.status}</td>
                                <td class="px-4 py-2">${order.date}</td>
                            </tr>
                        `;
                    });
                });
        }
        loadRecentOrders();
        // Optionally, refresh every 60 seconds
        setInterval(loadRecentOrders, 60000);

        let comparisonDataCache = null;

        function applyCardStyle(metric, change) {
            const card = document.querySelector(`.expandable-card[data-metric="${metric}"]`);
            if (!card) return;
            // reset
            card.classList.remove('ring-2', 'ring-green-400', 'ring-gray-300', 'ring-red-400', 'bg-green-50', 'bg-gray-50',
                'bg-red-50');
            if (change > 0) {
                card.classList.add('ring-2', 'ring-green-400', 'bg-green-50'); // profit
            } else if (change < 0) {
                card.classList.add('ring-2', 'ring-red-400', 'bg-red-50'); // loss
            } else {
                card.classList.add('ring-2', 'ring-gray-300', 'bg-gray-50'); // stable
            }
        }

        function updateFooters(data) {
            document.getElementById('products-footer-change').innerHTML = data.products.change_html;
            document.getElementById('revenue-footer-change').innerHTML = data.revenue.change_html;
            document.getElementById('stores-footer-change').innerHTML = data.stores.change_html;

            applyCardStyle('products', data.products.change);
            applyCardStyle('revenue', data.revenue.change);
            applyCardStyle('stores', data.stores.change);
        }

        function getComparisonData(callback) {
            if (comparisonDataCache) {
                callback(comparisonDataCache);
            } else {
                fetch("{{ route('seller.dashboard.comparisondata') }}")
                    .then(response => response.json())
                    .then(data => {
                        comparisonDataCache = data;
                        updateFooters(data);
                        callback(data);
                    });
            }
        }

        // Fetch comparison data on page load to populate footers
        getComparisonData(() => {});

        // Modify toggle event: use getComparisonData
        document.querySelectorAll('.toggle-expand-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const metric = this.getAttribute('data-metric');
                const card = this.closest('.expandable-card');
                const content = card.querySelector('.expandable-content');
                // Collapse others
                document.querySelectorAll('.expandable-content').forEach(el => {
                    if (el !== content) el.classList.add('hidden');
                });
                // Toggle this one
                content.classList.toggle('hidden');
                // Rotate chevron
                document.querySelectorAll('.toggle-expand-btn svg').forEach(svg => svg.classList.remove(
                    'rotate-180'));
                if (!content.classList.contains('hidden')) {
                    this.querySelector('svg').classList.add('rotate-180');
                    // Fetch or use cached comparison data
                    getComparisonData(function(data) {
                        if (metric === 'products') {
                            document.getElementById('products-this-month').textContent = data
                                .products.this_month;
                            document.getElementById('products-last-month').textContent = data
                                .products.last_month;
                        } else if (metric === 'revenue') {
                            document.getElementById('revenue-this-month').textContent = 'Rp' +
                                Number(data.revenue.this_month).toLocaleString('id-ID');
                            document.getElementById('revenue-last-month').textContent = 'Rp' +
                                Number(data.revenue.last_month).toLocaleString('id-ID');
                        } else if (metric === 'stores') {
                            document.getElementById('stores-this-month').textContent = data.stores
                                .this_month;
                            document.getElementById('stores-last-month').textContent = data.stores
                                .last_month;
                        }
                    });
                }
            });
        });

        // CountUp animations
        const counts = [{
                id: 'products-total-count'
            },
            {
                id: 'revenue-total-count',
                isCurrency: true
            },
            {
                id: 'stores-total-count'
            },
            {
                id: 'lowstock-total'
            },
            {
                id: 'nostock-total'
            }
        ];
        counts.forEach(item => {
            const el = document.getElementById(item.id);
            if (!el) return;
            const endVal = parseFloat(el.dataset.count);
            const options = item.isCurrency ? {
                prefix: 'Rp',
                separator: '.'
            } : {
                separator: ','
            };
            const countUp = new CountUp(item.id, endVal, options);
            if (!countUp.error) {
                countUp.start();
            }
        });
    </script>
@endsection
