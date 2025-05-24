@extends('layout.layout')
@php
    $title = empty($result) ? 'New Product' : "Edit $result->name Product";
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
    <div class="md:col-span-6 col-span-12">
        <div class="card border-0">
            <div class="card-header">
                <h5 class="text-lg font-semibold mb-0">
                    {{ empty($result) ? 'Input New Product' : 'Edit Product' }}
                </h5>

            </div>

            <div class="card-body">
                @include('layout.feedback')
                <form action="{{ empty($result) ? route('actionNewProduct') : route('actionEditProduct', "$result->id") }}"
                    method="POST"enctype="multipart/form-data">
                    @csrf

                    @if (!empty($result))
                        @method('PUT')
                    @endif


                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-12">
                            <label class="form-label">Name</label>
                            <div class="icon-field">
                                <span class="icon">
                                    <iconify-icon icon="iconamoon:category-fill"></iconify-icon>
                                </span>
                                <input type="text" name="name" class="form-control" placeholder="Enter product name"
                                    value="{{ old('name', $result->name ?? '') }}">
                            </div>
                        </div>

                        <div class="col-span-12">
                            <label class="form-label">Product Image </label>
                            <input class="border border-neutral-200 dark:border-neutral-600 w-full rounded-lg"
                                type="file" name="image">

                            @if (!empty($result) && $result->image)
                                <img id="preview-image" src="{{ asset('storage/' . $result->image) }}" alt="Product Image"
                                    class="w-100 mt-2 rounded-xl" style="max-width: 150px;">
                            @else
                                <img id="preview-image" src="#" alt="Product Image" class="w-100 rounded-xl mt-2"
                                    style="max-width: 150px; display: none;">
                            @endif

                            <script>
                                // preview image dom
                                document.querySelector('input[name="image"]').addEventListener('change', function(event) {
                                    const file = event.target.files[0];
                                    const previewImage = document.getElementById('preview-image');

                                    if (file) {
                                        const reader = new FileReader();
                                        reader.onload = function(e) {
                                            previewImage.src = e.target.result;
                                            previewImage.style.display = 'block';
                                        };
                                        reader.readAsDataURL(file);
                                    } else {
                                        previewImage.src = '#';
                                        previewImage.style.display = 'none';
                                    }
                                });
                            </script>
                        </div>
                        {{-- <div class="col-span-12">
                            <label class="form-label">Category</label>
                            <div class="icon-field">
                                <span class="icon">
                                    <iconify-icon icon="iconamoon:category-fill"></iconify-icon>
                                </span>
                                <input type="text" id="category-search" class="form-control"
                                    placeholder="Search category">
                            </div>
                            <div id="category-list" class="mt-2 border p-2" style="max-height: 200px; overflow-y: auto;">
                                <table class="table-auto w-full text-left">
                                    <thead>
                                        <tr>
                                            <th class="px-2 py-1 border">Category Name</th>
                                            <th class="px-2 py-1 border">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($categories as $category)
                                            <tr>
                                                <td class="px-2 py-1 border">{{ $category->name }}</td>
                                                <td class="px-2 py-1 border">
                                                    <button type="button" class="btn btn-sm btn-primary select-category"
                                                        data-id="{{ $category->id }}" data-name="{{ $category->name }}">
                                                        Select
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <input type="hidden" name="category_id" id="selected-category-id"
                                value="{{ $result->category_id ?? '' }}">
                        </div> --}}

                        <div class="col-span-12">
                            <label class="form-label">Category</label>
                            <div class="icon-field">
                                <span class="icon">
                                    <iconify-icon icon="iconamoon:category-fill"></iconify-icon>
                                </span>
                                <select name="category" class="form-control">
                                    <option value="">Select a category</option>
                                    @if (is_iterable($categories))
                                        @foreach ($categories as $category)
                                            <option name="category" value="{{ $category->id }}"
                                                {{ !empty($result) && $result->category_id == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="">No categories available</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-span-12">
                            <label class="form-label">SKU</label>
                            <div class="icon-field mb-2">
                                <span class="icon">
                                    <iconify-icon icon="mdi:barcode"></iconify-icon>
                                </span>
                                <input type="text" name="sku" id="sku-input" class="form-control"
                                    placeholder="Scan or enter product SKU" value="{{ $result->sku ?? '' }}" autofocus>
                            </div>
                            @if (!empty($result) && !empty($result->sku))
                                <div class="flex space-x-5">
                                    <button type="button" class="btn btn-primary-600"
                                        onclick="printBarcode('{{ $result->sku }}')">Print Barcode</button>
                                    <button type="button" class="btn btn-primary-600"
                                        onclick="window.open('{{ route('product.print-barcode', $result->id) }}', '_blank', 'width=400,height=100')">
                                        Print Barcode With Thermal
                                    </button>
                                    <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($result->sku, 'C128') }}"
                                        alt="barcode" />
                                </div>
                            @endif

                        </div>
                        <div class="col-span-12">
                            <label class="form-label">Price</label>
                            <div class="icon-field">
                                <span class="icon">
                                    <iconify-icon icon="mdi:currency-usd"></iconify-icon>
                                </span>
                                <input type="text" name="price" id="price-input" class="form-control"
                                    placeholder="Enter product price" value="{{ old('price', $result->price ?? '') }}">
                            </div>
                        </div>
                        <div class="col-span-12">
                            <label class="form-label">Stock</label>
                            <div class="icon-field">
                                <span class="icon">
                                    <iconify-icon icon="mdi:warehouse"></iconify-icon>
                                </span>
                                <input type="number" name="stock" class="form-control" placeholder="Enter product stock"
                                    value="{{ old('stock', $result->stock ?? '') }}">
                            </div>
                        </div>
                        <div class="col-span-12">
                            <label class="form-label">Discount</label>
                            <div class=" items-center gap-4">
                                <div class="col-span-12">
                                    <label class="form-label">Active</label>
                                    <div class="icon-field">
                                        <span class="icon">
                                            <iconify-icon
                                                icon="ic:twotone-discount"></iconify-icon>
                                        </span>
                                        <select name="is_discount" class="form-control">
                                            <option value="0"
                                                {{ old('is_discount', $result->is_discount ?? false) == false ? 'selected' : '' }}>
                                                No
                                            </option>
                                            <option value="1"
                                                {{ old('is_discount', $result->is_discount ?? false) == true ? 'selected' : '' }}>
                                                Yes
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <input type="number" name="discount" class="discount form-control w-32 mb-2"
                                    placeholder="Discount value" value="{{ old('discount', $result->discount ?? '') }}"
                                    {{ old('is_discount', $result->is_discount ?? false) ? '' : 'disabled' }}>
                                <select name="discount_type" class="discount-type form-control w-32"
                                    {{ old('is_discount', $result->is_discount ?? false) ? '' : 'disabled' }}>
                                    <option value="percent"
                                        {{ old('discount_type', $result->discount_type ?? '') == 'percent' ? 'selected' : '' }}>
                                        Percent
                                    </option>
                                    <option value="amount"
                                        {{ old('discount_type', $result->discount_type ?? '') == 'amount' ? 'selected' : '' }}>
                                        Amount
                                    </option>
                                </select>
                            </div>
                        </div>
                        <script>
                            // on off 
                            // Enable/disable discount fields based on is_discount select value
                            document.addEventListener('DOMContentLoaded', function() {
                                const isDiscountSelect = document.querySelector('select[name="is_discount"]');
                                const discountInput = document.querySelector('.discount');
                                const discountTypeSelect = document.querySelector('.discount-type');

                                function toggleDiscountFields() {
                                    const enabled = isDiscountSelect.value === '1';
                                    discountInput.disabled = !enabled;
                                    discountTypeSelect.disabled = !enabled;
                                }

                                isDiscountSelect.addEventListener('change', toggleDiscountFields);
                                toggleDiscountFields();
                            });
                        </script>
                        <div class="col-span-12">
                            <label class="form-label">Unit</label>
                            <div class="icon-field">
                                <span class="icon">
                                    <iconify-icon icon="mdi:scale-balance"></iconify-icon>
                                </span>
                                <input type="text" name="unit" class="form-control"
                                    placeholder="Enter product unit" value="{{ old('unit', $result->unit ?? '') }}">
                            </div>
                        </div>
                        <div class="col-span-12">
                            <label class="form-label">Description</label>
                            <div class="icon-field">
                                <span class="icon">
                                    <iconify-icon icon="fluent:text-description-16-filled"></iconify-icon>
                                </span>
                                <input type="text" name="description" class="form-control"
                                    placeholder="Enter product description" value="{{ $result->description ?? '' }}">
                            </div>
                        </div>
                        <div class="col-span-12">
                            <label class="form-label">Active</label>
                            <div class="icon-field">
                                <span class="icon">
                                    <iconify-icon
                                        icon="{{ !empty($result) && $result->is_active ? 'mdi:check-circle' : 'mdi:close-circle' }}"></iconify-icon>
                                </span>
                                <select name="is_active" class="form-control">
                                    <option value="0"
                                        {{ !empty($result) && ($result->is_active ?? false) == false ? 'selected' : '' }}>
                                        No</option>
                                    <option value="1"
                                        {{ !empty($result) && ($result->is_active ?? false) == true ? 'selected' : '' }}>
                                        Yes
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-span-12">
                            <button type="submit" class="btn btn-primary-600">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Automatically focus the SKU input field when the page loads
        document.getElementById('product-input').focus();

        // Event listener to handle additional logic after scanning
        document.getElementById('sku-input').addEventListener('input', function() {
            const sku = this.value;
            console.log(`Scanned SKU: ${sku}`);
            // end:: add additional logic here, such as validating the SKU or fetching product details
        });
    </script>

    <script>
        function printBarcode(sku) {
            if (!sku) {
                alert('SKU belum diisi!');
                return;
            }
            // Buat window baru untuk print
            var printWindow = window.open('', '', 'height=400,width=600');
            printWindow.document.write('<html><head><title>Print Barcode</title>');
            printWindow.document.write('</head><body style="text-align:center;">');
            printWindow.document.write('<h3>Barcode: ' + sku + '</h3>');
            printWindow.document.write(
                '<img src="data:image/png;base64,{{ DNS1D::getBarcodePNG("' + sku + '", 'C128') }}" />');
            printWindow.document.write('<br><span>' + sku + '</span>');
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.focus();
            setTimeout(function() {
                printWindow.print();
                printWindow.close();
            }, 500);
        }
    </script>

@endsection
