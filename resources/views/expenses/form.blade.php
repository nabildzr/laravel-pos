@extends('layout.layout')
@php
    $title = empty($result) ? 'New Expense' : "Edit $result->name Expense";
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
                    {{ empty($result) ? 'Input New Expense' : 'Edit Expense' }}
                </h5>

            </div>

            <div class="card-body">
                @include('layout.feedback')
                <form action="{{ empty($result) ? route('actionNewExpense') : route('actionEditExpense', "$result->id") }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf

                    @if (!empty($result))
                        @method('PUT')
                    @endif


                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-12">
                            <label class="form-label">Category</label>
                            <div class="icon-field">
                                <span class="icon">
                                    <iconify-icon icon="iconamoon:category-fill"></iconify-icon>
                                </span>
                                <select name="expense_category_id" class="form-control">
                                    @forelse($expenseCategories as $category)
                                        <option value="{{ $category->id }}" class="bg-neutral-500"
                                            {{ old('expense_category_id', empty($result) ? '' : $result->expense_category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>

                                    @empty
                                        <option disabled selected>Buat kategori terlebih dahulu</option>
                                    @endempty
                            </select>
                        </div>
                    </div>
                    <div class="col-span-12">
                        <label class="form-label">Date</label>
                        <div class="icon-field">
                            <span class="icon">
                                <iconify-icon icon="mdi:calendar"></iconify-icon>
                            </span>
                            <input type="date" name="date" class="form-control"
                                value="{{ old('date', empty($result) ? '' : \Carbon\Carbon::parse($result->date)->format('Y-m-d')) }}">
                        </div>
                    </div>
                    <div class="col-span-12">
                        <label class="form-label">Created At</label>
                        <div class="icon-field">
                            <span class="icon">
                                <iconify-icon icon="mdi:calendar"></iconify-icon>
                            </span>
                            <input type="date" class="form-control"
                                value="{{ empty($result) ? now()->format('Y-m-d') : \Carbon\Carbon::parse($result->created_at)->format('Y-m-d') }}"
                                disabled>
                        </div>
                    </div>
                    <div class="col-span-12">
                        <label class="form-label">Amount</label>
                        <div class="icon-field">
                            <span class="icon">
                                <iconify-icon icon="iconamoon:category-fill"></iconify-icon>
                            </span>
                            <input type="text" name="amount" class="form-control" placeholder="Enter expense amount"
                                value="{{ old('amount', empty($result) ? '' : "$result->amount") }}">
                        </div>
                    </div>
                    <div class="col-span-12">
                        <label class="form-label">Expense Proof </label>
                        <input class="border border-neutral-200 dark:border-neutral-600 w-full rounded-lg"
                            type="file" name="proof">

                        @if (!empty($result) && $result->proof)
                            <img id="preview-image" src="{{ asset('storage/' . $result->proof) }}" alt="Expense Proof"
                                class="w-100 mt-2 rounded-xl" style="max-width: 150px;">
                        @else
                            <img id="preview-image" src="#" alt="Expense Proof" class="w-100 rounded-xl mt-2"
                                style="max-width: 150px; display: none;">
                        @endif

                        <script>
                            // preview image dom
                            document.querySelector("input[name='proof']").addEventListener("change", function(event) {
                                const file = event.target.files[0];
                                const previewImage = document.getElementById("preview-image");

                                if (file) {
                                    const reader = new FileReader();
                                    reader.onload = function(e) {
                                        previewImage.src = e.target.result;
                                        previewImage.style.display = "block";
                                    };
                                    reader.readAsDataURL(file);
                                } else {
                                    previewImage.src = "#";
                                    previewImage.style.display = "none";
                                }
                            });
                        </script>

                    </div>
                    <div class="col-span-12">
                        <label class="form-label">Description</label>
                        <div class="icon-field">
                            <span class="icon">
                                <iconify-icon icon="fluent:text-description-16-filled"></iconify-icon>
                            </span>
                            <textarea type="text" name="description" class="form-control" placeholder="Enter description about the expense">{{ old('description', empty($result) ? '' : "$result->description") }}</textarea>
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
@endsection
