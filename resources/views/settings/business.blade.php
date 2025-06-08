@extends('layout.layout')
@php
    $title='Business';
    $subTitle = 'Settings - Business';
@endphp

@section('content')
    <div class="card h-full rounded-lg border-0">
        <div class="card-body p-10">
            @include('layout.feedback')
            
            <form action="{{ route('business.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div>
                    <div class="mb-5">
                        <label for="logo" class="text-sm font-semibold mb-2 block text-neutral-900 dark:text-white">Business Logo</label>
                        @if($business->logo)
                            <div class=" rounded-lg overflow-hidden mb-3" style="height: 200px; width:200px;">
                                <img src="{{ asset('storage/' . $business->logo) }}" alt="business Logo" class="object-cover w-full h-full">
                            </div>
                        @endif
                        <input type="file" name="logo" id="logo" class="form-control border border-neutral-200 dark:border-neutral-600 w-full rounded-lg">
                        @error('logo')
                            <span class="text-danger-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="name" class="text-sm font-semibold mb-2 block text-neutral-900 dark:text-white">Business Name <span class="text-danger-600">*</span></label>
                        <input type="text" class="form-control rounded-lg" id="name" name="name" value="{{ $business->name }}" placeholder="Enter Business Name" required>
                        @error('name')
                            <span class="text-danger-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="email" class="text-sm font-semibold mb-2 block text-neutral-900 dark:text-white">Email</label>
                        <input type="email" class="form-control rounded-lg" id="email" name="email" value="{{ $business->email }}" placeholder="Enter email address">
                        @error('email')
                            <span class="text-danger-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="phone" class="text-sm font-semibold mb-2 block text-neutral-900 dark:text-white">Phone Number</label>
                        <input type="text" class="form-control rounded-lg" id="phone" name="phone" value="{{ $business->phone }}" placeholder="Enter phone number">
                        @error('phone')
                            <span class="text-danger-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="website" class="text-sm font-semibold mb-2 block text-neutral-900 dark:text-white">Website</label>
                        <input type="url" class="form-control rounded-lg" id="website" name="website" value="{{ $business->website }}" placeholder="Website URL">
                        @error('website')
                            <span class="text-danger-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="tax_number" class="text-sm font-semibold mb-2 block text-neutral-900 dark:text-white">Tax Number / NPWP</label>
                        <input type="text" class="form-control rounded-lg" id="tax_number" name="tax_number" value="{{ $business->tax_number }}" placeholder="Enter Tax Number">
                        @error('tax_number')
                            <span class="text-danger-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="address" class="text-sm font-semibold mb-2 block text-neutral-900 dark:text-white">Address</label>
                        <textarea class="form-control rounded-lg" id="address" name="address" rows="3" placeholder="Enter Business Address">{{ $business->address }}</textarea>
                        @error('address')
                            <span class="text-danger-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="receipt_footer" class="text-sm font-semibold mb-2 block text-neutral-900 dark:text-white">Receipt Footer</label>
                        <textarea class="form-control rounded-lg" id="receipt_footer" name="receipt_footer" rows="2" placeholder="Footer text for receipts">{{ $business->receipt_footer }}</textarea>
                        <small class="text-sm text-neutral-500">This text will appear at the bottom of your receipts.</small>
                        @error('receipt_footer')
                            <span class="text-danger-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex items-center justify-center gap-3 mt-6">
                        <button type="submit" class="btn btn-primary border border-primary-600 text-base px-6 py-3 rounded-lg">
                            Save Changes
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection