@extends('layout.layout')

@php
    $title = 'Dashboard';
    $subTitle = 'Mini Cafe/Restaurant';
    // $script = '<script src="' . asset('assets/js/homethreeChart.js') . '"></script> ';
@endphp


@section('content')
    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
        @php
            $isAdminUser = auth()->check() && in_array(auth()->user()->role, ['admin', 'super_admin']);
        @endphp
        @if ($isAdminUser)
            <div class="md:col-span-12 2xl:col-span-12">
                <div class="card rounded-lg border-0">
                    <div class="grid grid-cols-1 2xl:grid-cols-12">
                        <div class="xl:col-span-12 2xl:col-span-6">
                            <div class="card-body p-6">
                                <div class="flex items-center flex-wrap gap-2 justify-between">
                                    <h6 class="mb-2 font-bold text-lg">Revenue Report</h6>

                                </div>
                                <ul class="flex flex-wrap items-center mt-4 gap-3">
                                    <li class="flex items-center gap-2">
                                        <span class="w-3 h-3 rounded-sm bg-primary-600"></span>
                                        <span class="text-secondary-light text-sm font-semibold">
                                            Earning:
                                            <span class="text-neutral-600 dark:text-neutral-200 font-bold">
                                                Rp {{ number_format($revenueData['totalRevenue'], 0, '.', '.') }}
                                            </span>
                                        </span>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <span class="w-3 h-3 rounded-sm bg-warning-600"></span>
                                        <span class="text-secondary-light text-sm font-semibold">
                                            Expense:
                                            <span class="text-neutral-600 dark:text-neutral-200 font-bold">
                                                Rp {{ number_format($revenueData['totalExpenses'], 0, '.', '.') }}
                                            </span>
                                        </span>
                                    </li>
                                </ul>
                                <div class="mt-[60px]">
                                    <div id="paymentStatusChart" class="margin-16-minus"></div>
                                </div>
                            </div>
                        </div>
                        {{-- grid --}}
                        <div class="xl:col-span-12 2xl:col-span-6 2xl:border-l border-neutral-200 dark:border-neutral-600">
                            <div class="grid grid-cols-1 sm:grid-cols-2 border-s-neutral-300">
                                <div
                                    class="card-body p-6 h-full flex flex-col border-b sm:border-r border-neutral-200 dark:border-neutral-600">
                                    <div class="flex flex-wrap items-center justify-between gap-1 mb-0.5">
                                        <div>
                                            <span
                                                class="w-[44px] h-[44px] text-primary-600 dark:text-primary-500 bg-primary-600/20 border border-primary-300 dark:border-primary-600/50 shrink-0 flex justify-center items-center rounded-lg h6 mb-4">
                                                <iconify-icon icon="fa-solid:box-open" class="icon"></iconify-icon>
                                            </span>
                                            <span class="mb-1 font-medium text-secondary-light text-base">Total
                                                Products</span>
                                            <h6 class="font-semibold text-neutral-900 mt-2 mb-px">
                                                {{ App\Models\Product::count() }}
                                            </h6>
                                        </div>
                                    </div>

                                </div>
                                <div
                                    class="card-body p-6 h-full flex flex-col border-b border-neutral-200 dark:border-neutral-600">
                                    <div class="flex flex-wrap items-center justify-between gap-1 mb-0.5">
                                        <div>
                                            <span
                                                class="w-[44px] h-[44px] text-warning-600 dark:text-warning-500 bg-warning-600/20 border border-warning-300 dark:border-warning-600/50 shrink-0 flex justify-center items-center rounded-lg h6 mb-4">
                                                <iconify-icon icon="flowbite:users-group-solid"
                                                    class="icon"></iconify-icon>
                                            </span>
                                            <span class="mb-1 font-medium text-secondary-light text-base">Total
                                                Customer</span>
                                            <h6 class="font-semibold text-neutral-900 mt-2 mb-px">
                                                {{ \App\Models\Member::count() }}</h6>
                                        </div>
                                    </div>
                                </div>


                                <div
                                    class="card-body p-6 h-full flex flex-col sm:border-r border-neutral-200 dark:border-neutral-600">
                                    <div class="flex flex-wrap items-center justify-between gap-1 mb-0.5">
                                        <div>
                                            <span
                                                class="w-[44px] h-[44px] text-purple-600 dark:text-purple-500 bg-purple-600/20 border border-purple-300 dark:border-purple-600/50 shrink-0 flex justify-center items-center rounded-lg h6 mb-4">
                                                <iconify-icon icon="majesticons:shopping-cart"
                                                    class="icon"></iconify-icon>
                                            </span>
                                            <span class="mb-1 font-medium text-secondary-light text-base">Today's Total
                                                Orders</span>
                                            <h6 class="font-semibold text-neutral-900 mt-2 mb-px">
                                                {{ \App\Models\Transaction::whereDate('created_at', now())->count() }}</h6>
                                        </div>
                                    </div>
                                    {{-- <p class="text-sm mb-0 mt-3">Increase by  <span class="bg-success-100 dark:bg-success-600/25 px-1 py-0.5 rounded-sm font-medium text-success-600 dark:text-success-500 text-sm">+1k</span> this week</p> --}}
                                </div>
                                <div class="card-body p-6 h-full flex flex-col">
                                    <div class="flex flex-wrap items-center justify-between gap-1 mb-0.5">
                                        <div>
                                            <span
                                                class="w-[44px] h-[44px] text-pink-600 dark:text-pink-500 bg-pink-600/20 border border-pink-300 dark:border-pink-600/50 shrink-0 flex justify-center items-center rounded-lg h6 mb-4">
                                                <iconify-icon icon="ri:discount-percent-fill" class="icon"></iconify-icon>
                                            </span>
                                            <span class="mb-1 font-medium text-secondary-light text-base">Today's Total
                                                Sales</span>
                                            <h6 class="font-semibold text-neutral-900 mt-2 mb-px">
                                                Rp
                                                {{ number_format(\App\Models\Transaction::whereDate('created_at', now())->sum('total_amount'), 0, '.', '.') }}
                                            </h6>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="md:col-span-12 lg:col-span-6 {{ $isAdminUser ? '2xl:col-span-9' : '2xl:col-span-12' }}">
            <div class="card h-full border-0">
                <div class="card-body p-6">
                    <div class="flex items-center flex-wrap gap-2 justify-between mb-5">
                        <h6 class="mb-2 font-bold text-lg">Recent Orders</h6>
                        <a href="{{ url('/transaction') }}"
                            class="text-primary-600 dark:text-primary-600 hover-text-primary flex items-center gap-1">
                            View All
                            <iconify-icon icon="solar:alt-arrow-right-linear" class="icon"></iconify-icon>
                        </a>
                    </div>
                    <div class="table-responsive scroll-sm">
                        <table class="table bordered-table mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">Users</th>
                                    <th scope="col">Invoice</th>
                                    <th scope="col">Items</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col" class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                    <tr>
                                        <td>
                                            <div class="flex items-center">
                                                <img src="{{ asset('assets/images/users/user1.png') }}" alt=""
                                                    class="shrink-0 me-3 rounded-lg">
                                                <span class="text-lg text-secondary-light font-semibold grow">
                                                    {{ optional($order->member)->name ?? 'Customer' }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>#{{ $order->invoice_number ?? $order->id }}</td>
                                        <td>
                                            @php
                                                $items = $order->details ?? [];
                                            @endphp
                                            {{ $items->count() > 0 ? $items->pluck('product.name')->implode(', ') : '-' }}
                                        </td>

                                        <td>
                                            Rp {{ number_format($order->total_amount, 0, '.', '.') }}
                                        </td>
                                        <td class="text-center">
                                            @if ($order->status == 'paid')
                                                <span
                                                    class="bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400 px-6 py-1.5 rounded-full font-medium text-sm">Paid</span>
                                            @else
                                                <span
                                                    class="bg-warning-100 dark:bg-warning-600/25 text-warning-600 dark:text-warning-400 px-6 py-1.5 rounded-full font-medium text-sm">{{ ucfirst($order->status) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class=" py-4 text-neutral-500" style="text-align: center">
                                            No transaction data available
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        @if ($isAdminUser)
            {{-- top payment method --}}
            <div class="md:col-span-12 lg:col-span-6 2xl:col-span-3">
                <div class="card h-full border-0">

                    <div class="card-body">
                        <div class="flex items-center flex-wrap gap-2 justify-between">
                            <h6 class="mb-2 font-bold text-lg">Transactions</h6>
                            <div class="">
                                <select
                                    class="form-select form-select-sm w-auto bg-white dark:bg-neutral-700 border text-secondary-light">
                                    <option>This Month</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-8">
                            @forelse($transactionsByPaymentMethod as $data)
                                <div class="flex items-center justify-between gap-3 mb-5">
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="w-10 h-10 rounded-lg shrink-0 bg-primary-100 text-primary-600 flex items-center justify-center">
                                            <iconify-icon icon="heroicons:credit-card" class="text-xl"></iconify-icon>
                                        </div>
                                        <div class="grow">
                                            <h6 class="text-base mb-0 font-normal">{{ $data['payment_method']->name }}</h6>
                                            <span
                                                class="text-sm text-secondary-light font-normal">{{ $data['reference'] }}</span>
                                        </div>
                                    </div>
                                    <span
                                        class="text-{{ $data['recent_transaction']->paid_amount >= 0 ? 'success' : 'danger' }}-600 text-base font-medium">
                                        Rp {{ number_format($data['recent_transaction']->total_amount, 0, '.', '.') }}
                                    </span>
                                </div>

                            @empty
                                <div class="text-center py-4 text-neutral-500">No transaction data available</div>
                            @endforelse

                            {{-- @if (count($transactionsByPaymentMethod) == 0)
                                    <!-- Fallback placeholder content -->
                                    <div class="flex items-center justify-between gap-3 mb-5">
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="w-10 h-10 rounded-lg shrink-0 bg-neutral-100 text-neutral-600 flex items-center justify-center">
                                                <iconify-icon icon="heroicons:credit-card" class="text-xl"></iconify-icon>
                                            </div>
                                            <div class="grow">
                                                <h6 class="text-base mb-0 font-normal">Cash</h6>
                                                <span class="text-sm text-secondary-light font-normal">No transactions
                                                    yet</span>
                                            </div>
                                        </div>
                                        <span class="text-neutral-600 text-base font-medium">Rp 0</span>
                                    </div>
                                @endif --}}


                        </div>
                    </div>
                </div>
            </div>
        @endif


        {{-- top customers --}}
        <div class="md:col-span-12 lg:col-span-6 2xl:col-span-4">
            <div class="card h-full border-0">
                <div class="card-body">
                    <div class="flex items-center flex-wrap gap-2 justify-between mb-5">
                        <h6 class="mb-2 font-bold text-lg">Top Customers</h6>
                        <a href="{{ url('/member') }}"
                            class="text-primary-600 dark:text-primary-600 hover-text-primary flex items-center gap-1">
                            View All
                            <iconify-icon icon="solar:alt-arrow-right-linear" class="icon"></iconify-icon>
                        </a>
                    </div>

                    <div class="mt-8">
                        @forelse($topCustomers as $customer)
                            <div class="flex items-center justify-between gap-3 mb-8">
                                <div class="flex items-center gap-2">
                                    <div
                                        class="w-10 h-10 bg-primary-100 dark:bg-primary-600/25 rounded-lg shrink-0 flex items-center justify-center text-primary-600 dark:text-primary-400">
                                        <span
                                            class="text-lg font-medium">{{ strtoupper(substr($customer->name, 0, 1)) }}</span>
                                    </div>
                                    <div class="grow">
                                        <h6 class="text-base mb-0 font-normal">{{ $customer->name }}</h6>
                                        <span
                                            class="text-sm text-secondary-light font-normal">{{ $customer->phone_number }}</span>
                                    </div>
                                </div>
                                <span class="text-neutral-600 dark:text-neutral-200 text-base font-medium">Orders:
                                    {{ $customer->order_count }}</span>
                            </div>
                        @empty
                            <div class="flex items-center justify-center py-6 text-neutral-500">
                                No customer data available
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- top seelling product --}}
        <div class="md:col-span-12 2xl:col-span-8">
            <div class="card h-full border-0">
                <div class="card-body p-6">
                    <div class="flex items-center flex-wrap gap-2 justify-between mb-5">
                        <h6 class="mb-2 font-bold text-lg">Top Selling Products</h6>
                        <a href="{{ url('/product') }}"
                            class="text-primary-600 dark:text-primary-600 hover-text-primary flex items-center gap-1">
                            View All
                            <iconify-icon icon="solar:alt-arrow-right-linear" class="icon"></iconify-icon>
                        </a>
                    </div>
                    <div class="table-responsive scroll-sm">
                        <table class="table bordered-table mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">Items</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Discount</th>
                                    <th scope="col">Sold</th>
                                    <th scope="col" class="text-center">Total Orders</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topSellingProducts as $product)
                                    <tr>
                                        <td>
                                            <div class="flex items-center">
                                                @if ($product->image)
                                                    <img src="{{ asset('storage/' . $product->image) }}"
                                                        alt="{{ $product->name }}"
                                                        class="w-10 h-10 object-cover shrink-0 me-3 rounded-lg">
                                                @else
                                                    <div
                                                        class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center shrink-0 me-3">
                                                        <iconify-icon icon="mdi:cube-outline"
                                                            class="text-gray-500 text-xl"></iconify-icon>
                                                    </div>
                                                @endif
                                                <div class="grow">
                                                    <h6 class="text-base mb-0 font-normal">{{ $product->name }}</h6>
                                                    <span
                                                        class="text-sm text-secondary-light font-normal">{{ $product->category_name ?? 'Uncategorized' }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Rp {{ number_format($product->price, 0, '.', '.') }}</td>
                                        <td>
                                            @if ($product->is_discount)
                                                @if ($product->discount_type == 'percentage')
                                                    {{ $product->discount }}%
                                                @else
                                                    Rp {{ number_format($product->discount, 0, '.', '.') }}
                                                @endif
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>{{ $product->total_sold }}</td>
                                        <td class="text-center">
                                            <span
                                                class="bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400 px-4 py-1.5 rounded-full font-medium text-sm">
                                                {{ $product->order_count }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" style="text-align: center" class=" py-4 text-neutral-500 ">
                                            No product sales data available
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var revenueData = @json($revenueData['revenue']);
            var expenseData = @json($revenueData['expenses']);

            var options = {
                series: [{
                    name: 'Revenue',
                    data: revenueData
                }, {
                    name: 'Expense',
                    data: expenseData
                }],
                colors: ['#487FFF', '#FF9F29'],
                chart: {
                    type: 'bar',
                    height: 250,
                    toolbar: {
                        show: false
                    },
                },
                grid: {
                    show: true,
                    borderColor: '#D1D5DB',
                    strokeDashArray: 4,
                    position: 'back',
                },
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        columnWidth: 10,
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov',
                        'Dec'
                    ],
                },
                yaxis: {
                    labels: {
                        formatter: function(value) {
                            return "Rp " + new Intl.NumberFormat('id-ID').format(value);
                        }
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return "Rp " + new Intl.NumberFormat('id-ID').format(val);
                        }
                    }
                },
                fill: {
                    opacity: 1,
                    width: 18,
                },
            };

            if (document.querySelector("#paymentStatusChart")) {
                var chart = new ApexCharts(document.querySelector("#paymentStatusChart"), options);
                chart.render();
            }
        });
    </script>
@endsection
