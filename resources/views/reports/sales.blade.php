@extends('layout.layout')
@php
    $title = 'Laporan Penjualan';
    $subTitle = 'Point of Sales';
    $script = '<script src="' . asset('assets/js/data-table.js') . '"></script>
        <script>
            $(".remove-button").on("click", function() {
                $(this).closest(".alert").addClass("hidden")
            });
        </script>
    
    <script>
        document.getElementById("closeModal").addEventListener("click", function() {
            const modal = this.closest(".modal");
            if (modal) {
                modal.classList.add("hidden");
            }
        });
    </script>
';
@endphp

@section('content')
    <div class="grid grid-cols-12">
        <div class="col-span-12">
            <div class="card border-0 overflow-hidden">
                <div class="card-header">
                    <h6 class="card-title mb-0 text-lg">Sales Datatables</h6>
                </div>
                <form action="{{ route('reports.sales.export') }}" method="GET"
                    class="flex flex-wrap items-end gap-3 px-6 pt-2 rounded-lg">
                    <div class="flex flex-col">
                        <label for="from"
                            class="text-sm font-medium text-neutral-700 dark:text-neutral-200 mb-1">From</label>
                        <input type="date" name="from" id="from"
                            class="form-input rounded-md border border-neutral-300 dark:border-neutral-600 focus:ring-primary-500 focus:border-primary-500 dark:bg-neutral-800 dark:text-white"
                            required>
                    </div>
                    <div class="flex flex-col">
                        <label for="to"
                            class="text-sm font-medium text-neutral-700 dark:text-neutral-200 mb-1">To</label>
                        <input type="date" name="to" id="to"
                            class="form-input rounded-md border border-neutral-300 dark:border-neutral-600 focus:ring-primary-500 focus:border-primary-500 dark:bg-neutral-800 dark:text-white"
                            required>
                    </div>
                    <button type="submit"
                        class="btn btn-success px-6 py-2 rounded-md font-semibold hover:bg-green-700 transition-colors mt-5 md:mt-0 gap-1 border border-neutral-300 bg-neutral-300 dark:border-neutral-600 dark:bg-neutral-800">
                        <iconify-icon icon="vscode-icons:file-type-excel" class="icon text-lg "></iconify-icon>
                        Export Excel
                    </button>
                    <button type="submit" formaction="{{ route('reports.sales.export-pdf') }}"
                        class="btn btn-danger px-6 py-2 rounded-md font-semibold hover:bg-red-700 transition-colors mt-5 md:mt-0 gap-1 border border-neutral-300 bg-neutral-300 dark:border-neutral-600 dark:bg-neutral-800">
                        <iconify-icon icon="vscode-icons:file-type-pdf2" class="icon text-lg"></iconify-icon>
                        Export PDF
                    </button>
                </form>
                <div class="card-body">
                    @include('layout.feedback')
                    <table id="selection-table"
                        class="border border-neutral-200 dark:border-neutral-600 rounded-lg border-separate	">
                        <thead>
                            <tr>
                                <th scope="col" class="text-neutral-800 dark:text-white">
                                    <div class="form-check style-check flex items-center">
                                        <input class="form-check-input" id="select-all" type="checkbox">
                                        <label class="ms-2 form-check-label" for="serial">
                                            S.L
                                        </label>
                                    </div>
                                </th>
                                <th scope="col" class="text-neutral-800 dark:text-white">
                                    <div class="flex items-center gap-4">
                                        Tanggal
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                        </svg>
                                    </div>
                                </th>
                                <th scope="col" class="text-neutral-800 dark:text-white">
                                    <div class="flex items-center gap-4">
                                        Kasir
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                        </svg>
                                    </div>
                                </th>
                                <th scope="col" class="text-neutral-800 dark:text-white">
                                    <div class="flex items-center gap-4">
                                        Member
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                        </svg>
                                    </div>
                                </th>
                                <th scope="col" class="text-neutral-800 dark:text-white">
                                    <div class="flex items-center gap-4">
                                        Metode Pembayaran
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                        </svg>
                                    </div>
                                </th>
                                <th scope="col" class="text-neutral-800 dark:text-white">
                                    <div class="flex items-center gap-4">
                                        Produk
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                        </svg>
                                    </div>
                                </th>
                                <th scope="col" class="text-neutral-800 dark:text-white">
                                    <div class="flex items-center gap-4">
                                        SKU
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                        </svg>
                                    </div>
                                </th>
                                <th scope="col" class="text-neutral-800 dark:text-white">
                                    <div class="flex items-center gap-4">
                                        Jumlah
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                        </svg>
                                    </div>
                                </th>
                                <th scope="col" class="text-neutral-800 dark:text-white">
                                    <div class="flex items-center gap-4">
                                        Harga Satuan
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                        </svg>
                                    </div>
                                </th>
                                <th scope="col" class="text-neutral-800 dark:text-white">
                                    <div class="flex items-center gap-4">
                                        Diskon
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                        </svg>
                                    </div>
                                </th>
                                <th scope="col" class="text-neutral-800 dark:text-white">
                                    <div class="flex items-center gap-4">
                                        Subtotal
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                        </svg>
                                    </div>
                                </th>
                                <th scope="col" class="text-neutral-800 dark:text-white">
                                    <div class="flex items-center gap-4">
                                        Total Transaksi
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                        </svg>
                                    </div>
                                </th>
                                <th scope="col" class="text-neutral-800 dark:text-white">
                                    <div class="flex items-center gap-4">
                                        Status
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                        </svg>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales as $row)
                                <tr>
                                    <td>
                                        <div class="form-check style-check flex items-center">
                                            <input type="checkbox" name="selected[]" value="{{ $row->id }}"
                                                class="form-check-input">
                                            <label class="ms-2 form-check-label">
                                                {{ $row->id }}
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <h6 class="text-base mb-0 font-bold grow">{{ $row->created_at }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-base mb-0 font-bold grow">{{ $row->user->name ?? '-' }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-base mb-0 font-bold grow">{{ $row->member->name ?? '-' }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-base mb-0 font-bold grow">{{ $row->paymentMethod->name ?? '-' }}
                                        </h6>
                                    </td>
                                    <td>
                                        @foreach ($row->transactionDetails as $detail)
                                            {{ $detail->product->name ?? '-' }}@if (!$loop->last)
                                                ,
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($row->transactionDetails as $detail)
                                            {{ $detail->product->sku ?? '-' }}@if (!$loop->last)
                                                ,
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($row->transactionDetails as $detail)
                                            {{ $detail->quantity }}@if (!$loop->last)
                                                ,
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($row->transactionDetails as $detail)
                                            {{ $detail->price }}@if (!$loop->last)
                                                ,
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($row->transactionDetails as $detail)
                                            {{ $detail->product && $detail->product->is_discount ? $detail->product->discount : '-' }}
                                            @if (!$loop->last)
                                                ,
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($row->transactionDetails as $detail)
                                            {{ $detail->total }}@if (!$loop->last)
                                                ,
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>{{ $row->total_amount }}</td>
                                    <td>
                                        @if ($row->status == 'pending')
                                            <span
                                                class="bg-warning-100 dark:bg-warning-600/25 text-warning-600 dark:text-warning-400 border border-warning-600 px-6 py-1.5 rounded font-medium text-sm">Pending</span>
                                        @elseif ($row->status == 'paid')
                                            <span
                                                class="bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400 border border-success-600 px-6 py-1.5 rounded font-medium text-sm">Paid</span>
                                        @elseif ($row->status == 'cancelled')
                                            <span
                                                class="bg-neutral-200 dark:bg-neutral-600 text-neutral-600 border border-neutral-400 px-6 py-1.5 rounded font-medium text-sm">Cancelled</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
