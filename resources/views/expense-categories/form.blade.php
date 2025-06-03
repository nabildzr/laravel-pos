@extends('layout.layout')
@php
    $title = empty($result) ? 'New Expense Category' : "Edit $result->name Expense Category";
    $subTitle = 'Point of Sales';
    $script = '<script src="' . asset('assets/js/data-table.js') . '"></script>
    <script>
              $(".remove-button").on("click", function() {
                            $(this).closest(".alert").addClass("hidden")
                        });</script/>
    ';
@endphp

@section('content')
    <div class="md:col-span-6 col-span-12">
        <div class="card border-0">
            <div class="card-header">
                <h5 class="text-lg font-semibold mb-0">
                    {{ empty($result) ? 'Input New Expense Category' : 'Edit Expense Category' }}
                </h5>

            </div>

            <div class="card-body">
                @include('layout.feedback')
                <form action="{{ empty($result) ? route('actionNewExpenseCategory') : route('actionEditExpenseCategory', "$result->id") }}" method="POST">
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
                                <input type="text" name="name" class="form-control" placeholder="Enter category name" value="{{ empty($result) ? "" : "$result->name" }}">
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
