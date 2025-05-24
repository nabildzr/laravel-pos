@extends('layout.layout')
@php
    $title = empty($result) ? 'New Payment Method' : "Edit $result->name Payment Method";
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
                    {{ empty($result) ? 'Input New Payment Method' : 'Edit Payment Method' }}
                </h5>

            </div>

            <div class="card-body">
                @include('layout.feedback')
                <form action="{{ empty($result) ? route('actionNewPaymentMethod') : route('actionEditPaymentMethod', "$result->id") }}"
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

@endsection
