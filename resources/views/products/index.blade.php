@extends('layout.layout')
@php
    $title = 'Products';
    $subTitle = 'Point of Sales';
    $script = '<script src="' . asset('assets/js/data-table.js') . '"></script>
    <script>
        $(".remove-button").on("click", function() {
            $(this).closest(".alert").addClass("hidden")
        });
    </script>
    
    
    
    ';
@endphp

@section('content')
    <div class="grid grid-cols-12">
        <div class="col-span-12">
            <div class="card border-0 overflow-hidden">
                <div class="card-header">
                    <h6 class="card-title mb-0 text-lg">Product Datatables</h6>
                </div>


                <div class="card-body">
                    @include('layout.feedback')

                    <div class="flex items-center space-x-2 mb-4">
                        <a href="{{ route('newProduct') }}"
                            class="btn bg-primary-600 hover:bg-primary-700 text-white rounded-lg px-5 py-[11px]">Create new
                            Product</a>

                        <a href="{{ route('product.export-csv') }}"
                            class="btn bg-neutral-200 dark:bg-neutral-700 hover:bg-neutral-300 dark:hover:bg-neutral-600 text-neutral-800 dark:text-white px-5 py-2 rounded-md font-semibold transition-colors ">
                            <iconify-icon icon="foundation:page-export-csv" class="icon text-lg"></iconify-icon>
                            Export CSV
                        </a>

                        <!-- Import CSV Button -->
                        <button type="button" data-modal-target="import-modal" data-modal-toggle="import-modal"
                            class="btn bg-neutral-200 dark:bg-neutral-700 hover:bg-neutral-300 dark:hover:bg-neutral-600 text-neutral-800 dark:text-white px-5 py-2 rounded-md font-semibold transition-colors">
                            <iconify-icon icon="carbon:document-import" class="icon text-lg"></iconify-icon>
                            Import CSV
                        </button>

                        <a href="{{ route('product.download-template') }}"
                            class="btn bg-neutral-200 dark:bg-neutral-700 hover:bg-neutral-300 dark:hover:bg-neutral-600 text-neutral-800 dark:text-white px-5 py-2 rounded-md font-semibold transition-colors">
                            <iconify-icon icon="material-symbols:download" class="icon text-lg"></iconify-icon>
                            Download Template
                        </a>
                    </div>
                    <table id="selection-table"
                        class="border border-neutral-200 dark:border-neutral-600 rounded-lg border-separate	">
                        <thead>
                            <tr>
                                <th scope="col" class="text-neutral-800 dark:text-white">
                                    <div class="form-check style-check flex items-center">
                                        <label class="ms-2 form-check-label" for="serial">
                                            S.L
                                        </label>
                                    </div>
                                </th>

                                <th scope="col" class="text-neutral-800 dark:text-white">
                                    <div class="flex items-center gap-2">
                                        Product Name
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                        </svg>
                                    </div>
                                </th>
                                <th scope="col" class="text-neutral-800 dark:text-white">
                                    <div class="flex items-center gap-2">
                                        SKU
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                        </svg>
                                    </div>
                                </th>
                                <th scope="col" class="text-neutral-800 dark:text-white">
                                    <div class="flex items-center gap-2">
                                        Stock
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                        </svg>
                                    </div>
                                </th>
                                <th scope="col" class="text-neutral-800 dark:text-white">
                                    <div class="flex items-center gap-2">
                                        Category
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                        </svg>
                                    </div>
                                </th>
                                <th scope="col" class="text-neutral-800 dark:text-white">
                                    <div class="flex items-center gap-2">
                                        Created By
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                        </svg>
                                    </div>
                                </th>
                                <th scope="col" class="text-neutral-800 dark:text-white">
                                    <div class="flex items-center gap-2">
                                        Description
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                        </svg>
                                    </div>
                                </th>
                                <th scope="col" class="text-neutral-800 dark:text-white">
                                    <div class="flex items-center gap-2">
                                        Status
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                        </svg>
                                    </div>
                                </th>
                                <th scope="col" class="text-neutral-800 dark:text-white">
                                    <div class="flex items-center gap-2">
                                        Discount Status
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                        </svg>
                                    </div>
                                </th>
                                <th scope="col" class="text-neutral-800 dark:text-white">
                                    <div class="flex items-center gap-2">
                                        Discount Type
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                        </svg>
                                    </div>
                                </th>
                                <th scope="col" class="text-neutral-800 dark:text-white">
                                    <div class="flex items-center gap-2">
                                        Discount Value
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                        </svg>
                                    </div>
                                </th>

                                {{-- <th scope="col" class="text-neutral-800 dark:text-white">
                                    <div class="flex items-center gap-2">
                                        Status
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                        </svg>
                                    </div>
                                </th> --}}
                                <th scope="col" class="text-neutral-800 dark:text-white">
                                    <div class="flex items-center gap-2">
                                        Action
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>
                                        <div class="form-check style-check flex items-center">
                                            <label class="ms-2 form-check-label">
                                                {{ $product->id }}
                                            </label>
                                        </div>
                                    </td>


                                    <td>
                                        <div class="flex items-center">
                                            @if ($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" alt=""
                                                    class="shrink-0 me-3 rounded-lg w-10">
                                            @else
                                                <img src="{{ asset('') }}" alt=""
                                                    class="shrink-0 me-3 rounded-lg w-10 bg-white">
                                            @endif
                                            <h6 class="text-base mb-0 font-bold grow">{{ $product->name }}</h6>
                                        </div>
                                    </td>


                                    <td>
                                        <h6 class="text-base mb-0 font-medium grow">
                                            {{ $product->sku }}
                                        </h6>
                                    </td>

                                    <td>
                                        <h6 class="text-base mb-0 font-medium grow">
                                            {{ $product->stock }} {{ $product->unit }}
                                        </h6>
                                    </td>

                                    <td>
                                        <h6 class="text-base mb-0 font-medium grow underline">
                                            <a href="{{ url('/category') }}"
                                                class="text-primary-600 hover:text-primary-600">
                                                {{ $product->category->name }}
                                            </a>
                                        </h6>
                                    </td>

                                    <td>
                                        <h6 class="text-base mb-0 font-medium grow">{{ $product->user->name }}</h6>
                                    </td>


                                    <td>
                                        <div class="flex items-center">

                                            <h6 class="text-base mb-0 font-medium grow">{{ $product->description }}</h6>
                                        </div>
                                    </td>


                                    <td>
                                        <div class="flex justify-center items-center">
                                            @if ($product->is_active)
                                                <span
                                                    class="bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400 px-6 py-1.5 rounded-full font-medium text-sm">Active</span>
                                            @else
                                                <span
                                                    class="bg-danger-100 dark:bg-danger-600/25 text-danger-600 dark:text-danger-400 px-6 py-1.5 rounded-full font-medium text-sm">Not
                                                    Active</span>
                                            @endif
                                        </div>
                                    <td>
                                        <div class="flex justify-center items-center">
                                            @if ($product->is_discount)
                                                <span
                                                    class="bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400 px-6 py-1.5 rounded-full font-medium text-sm">Discount</span>
                                            @else
                                                <span
                                                    class="bg-danger-100 dark:bg-danger-600/25 text-danger-600 dark:text-danger-400 px-6 py-1.5 rounded-full font-medium text-sm">Discount
                                                    Not Active</span>
                                            @endif
                                        </div>

                                    </td>


                                    <td>
                                        <div class="flex justify-center items-center">
                                            {{ $product->discount_type ?? '-' }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex justify-center items-center">
                                            {{ $product->discount ?? '-' }}
                                        </div>
                                    </td>
                                    <td>
                                        <a data-modal-target="add-stock-modal-{{ $product->id }}"
                                            data-modal-toggle="add-stock-modal-{{ $product->id }}"
                                            class="w-8 h-8 bg-primary-100 dark:bg-primary-600/25 text-primary-600 dark:text-primary-400 rounded-full inline-flex items-center justify-center">
                                            <iconify-icon icon="ix:product"></iconify-icon>
                                        </a>
                                        <a href="{{ url("/product/edit/$product->id") }}"
                                            class="w-8 h-8 bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400 rounded-full inline-flex items-center justify-center">
                                            <iconify-icon icon="lucide:edit"></iconify-icon>
                                        </a>

                                        <a data-modal-target="delete-modal-{{ $product->id }}"
                                            data-modal-toggle="delete-modal-{{ $product->id }}"
                                            class="w-8 h-8 bg-danger-100 dark:bg-danger-600/25 text-danger-600 dark:text-danger-400 rounded-full inline-flex items-center justify-center">
                                            <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                        </a>
                                    </td>
                                </tr>

                                <x-confirm-delete-modal :modalId="'delete-modal-' . $product->id" :route="route('actionDeleteProduct', $product->id)" />


                                <x-update-product-stock-modal :product="$product" :modalId="'add-stock-modal-' . $product->id" :route="route('actionAddStockProduct', $product->id)" />
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div id="import-modal" tabindex="-1" aria-hidden="true"
        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                        Import Products from CSV
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="import-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <div class="p-6 space-y-6">
                    <form action="{{ route('product.import-csv') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-4">
                        @csrf
                        <div>
                            <label for="file"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select CSV
                                File</label>
                            <input type="file" name="file" id="file"
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                accept=".csv" required>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">CSV file with product data.</p>
                        </div>

                        <button type="submit"
                            class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Import Products
                        </button>

                        <div class="text-sm text-gray-500 dark:text-gray-300">
                            <p>Format columns: name, sku, price, stock, unit, category, description, is_active, is_discount,
                                discount_type, discount_value</p>
                            <p class="mt-1">Download the template for correct format.</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
