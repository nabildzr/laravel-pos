@extends('layout.layout')
@php
    $title = empty($result) ? 'New Member' : "Edit $result->name Member";
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
                    {{ empty($result) ? 'Input New Member' : 'Edit Member' }}
                </h5>

            </div>

            <div class="card-body">
                @include('layout.feedback')
                <form action="{{ empty($result) ? route('actionNewMember') : route('actionEditMember', "$result->id") }}"
                    method="POST"enctype="multipart/form-data">
                    @csrf

                    @if (!empty($result))
                        @method('PUT')
                    @endif


                    <div class="grid grid-cols-12 gap-4">
                        @if (!empty($result))
                            <div class="col-span-12">
                                <label class="form-label">Member ID</label>
                                <div class="icon-field">
                                    <span class="icon">
                                        <iconify-icon icon="solar:user-id-bold"></iconify-icon>
                                    </span>
                                    <input type="text" class="form-control " placeholder="Enter product name"
                                        value="{{ old('id', $result->id ?? '') }}" disabled>
                                </div>
                            </div>
                        @endif
                        <div class="col-span-12">
                            <label class="form-label">Name</label>
                            <div class="icon-field">
                                <span class="icon">
                                    <iconify-icon icon="solar:user-bold"></iconify-icon>
                                </span>
                                <input type="text" name="name" class="form-control" placeholder="Enter product name"
                                    value="{{ old('name', $result->name ?? '') }}">
                            </div>
                        </div>
                        <div class="col-span-12">
                            <label class="form-label">Phone Number</label>
                            <div class="icon-field">
                                <span class="icon">
                                    <iconify-icon icon="solar:phone-bold"></iconify-icon>
                                </span>
                                <input type="number" name="phone_number" class="form-control"
                                    placeholder="Enter phone Number"
                                    value="{{ old('phone_number', $result->phone_number ?? '') }}">
                            </div>
                        </div>
                        <div class="col-span-12">
                            <label class="form-label">Email</label>
                            <div class="icon-field">
                                <span class="icon">
                                    <iconify-icon icon="mdi:email"></iconify-icon>
                                </span>
                                <input type="email" name="email" class="form-control" placeholder="Enter member Email"
                                    value="{{ old('email', $result->email ?? '') }}">
                            </div>
                        </div>
                        <div class="col-span-12">
                            <label class="form-label">Address</label>
                            <div class="icon-field">
                                <span class="icon">
                                    <iconify-icon icon="material-symbols:location-on"></iconify-icon>
                                </span>
                                <input type="text" name="address" class="form-control" placeholder="Enter member address"
                                    value="{{ old('address', $result->address ?? '') }}">
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
