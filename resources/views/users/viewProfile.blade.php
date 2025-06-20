@extends('layout.layout')
@php
    $title = 'View Profile';
    $subTitle = 'View Profile';
    $script = '<script>
        // ======================== Upload Image Start =====================
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $("#imagePreview").css("background-image", "url(" + e.target.result + ")");
                    $("#imagePreview").hide();
                    $("#imagePreview").fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#imageUpload").change(function() {
            readURL(this);
        });
        // ======================== Upload Image End =====================

        // ================== Password Show Hide Js Start ==========
        function initializePasswordToggle(toggleSelector) {
            $(toggleSelector).on("click", function() {
                $(this).toggleClass("ri-eye-off-line");
                var input = $($(this).attr("data-toggle"));
                if (input.attr("type") === "password") {
                    input.attr("type", "text");
                } else {
                    input.attr("type", "password");
                }
            });
        }
        // Call the function
        initializePasswordToggle(".toggle-password");
        // ========================= Password Show Hide Js End ===========================
    </script>';
@endphp

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <div class="col-span-12 lg:col-span-4">
            <div
                class="user-grid-card relative border border-neutral-200 dark:border-neutral-600 rounded-2xl overflow-hidden bg-white dark:bg-neutral-700 h-full">
                <img src="{{ asset('assets/images/banner.png') }}" alt=""
                    style="width: 100%; height: 10px object-fit: cover;">
                <div class="pb-6 ms-6 mb-6 me-6 -mt-[100px]">
                    <div class="text-center border-b border-neutral-200 dark:border-neutral-600">
                        @if (isset($user) && !empty($user->profile_image))
                            <img src="{{ asset('storage/' . $user->profile_image) }}"
                                alt="Profile Image"class="border br-white border-width-2-px  rounded-full object-fit-cover mx-auto"
                                style="width: 200px; height: 200px; object-fit: cover;">
                        @else
                            <img src="https://i.pinimg.com/736x/d9/d8/8e/d9d88e3d1f74e2b8ced3df051cecb81d.jpg" alt="Profile Image"
                                class="border br-white border-width-2-px w-200-px h-[200px] rounded-full object-fit-cover mx-auto">
                        @endif

                        <h6 class="mb-0 mt-4">{{ $user->name ?? 'Not Found' }}</h6>
                        <span class="text-secondary-light mb-4">{{ $user->email ?? 'Not Found' }}</span>
                    </div>
                    <div class="mt-6">
                        <h6 class="text-xl mb-4">Personal Info</h6>
                        <ul>
                            <li class="flex items-center gap-1 mb-3">
                                <span class="w-[30%] text-base font-semibold text-neutral-600 dark:text-neutral-200"> Full
                                    Name</span>
                                <span class="w-[70%] text-secondary-light font-medium">:
                                    {{ $user->full_name ?? 'Not Found' }}</span>
                            </li>
                            <li class="flex items-center gap-1 mb-3">
                                <span class="w-[30%] text-base font-semibold text-neutral-600 dark:text-neutral-200">
                                    Email</span>
                                <span class="w-[70%] text-secondary-light font-medium">:
                                    {{ $user->email ?? 'Not Found' }}</span>
                            </li>
                            <li class="flex items-center gap-1 mb-3">
                                <span class="w-[30%] text-base font-semibold text-neutral-600 dark:text-neutral-200"> Phone
                                    Number</span>
                                <span class="w-[70%] text-secondary-light font-medium">:
                                    {{ $user->phone_number ?? 'Not Found' }}</span>
                            </li>
                            <li class="flex items-center gap-1 mb-3">
                                <span
                                    class="w-[30%] text-base font-semibold text-neutral-600 dark:text-neutral-200">Role</span>
                                <span class="w-[70%] text-secondary-light font-medium">:
                                    {{ isset($user->role) ? Str::of($user->role)->replace('_', ' ')->title() : 'Not Found' }}
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-span-12 lg:col-span-8">
            <div class="card h-full border-0">
                <div class="card-body p-6">

                    <ul class="tab-style-gradient flex flex-wrap text-sm font-medium text-center mb-5" id="default-tab"
                        data-tabs-toggle="#default-tab-content" role="tablist">
                        <li class="" role="presentation">
                            <button
                                class="py-2.5 px-4 border-t-2 font-semibold text-base inline-flex items-center gap-3 text-neutral-600"
                                id="edit-profile-tab" data-tabs-target="#edit-profile" type="button" role="tab"
                                aria-controls="edit-profile" aria-selected="false">
                                Edit Profile
                            </button>
                        </li>
                        <li class="" role="presentation">
                            <button
                                class="py-2.5 px-4 border-t-2 font-semibold text-base inline-flex items-center gap-3 text-neutral-600 hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                id="change-password-tab" data-tabs-target="#change-password" type="button" role="tab"
                                aria-controls="change-password" aria-selected="false">
                                Change Password
                            </button>
                        </li>
                        <li class="" role="presentation">
                            <button
                                class="py-2.5 px-4 border-t-2 font-semibold text-base inline-flex items-center gap-3 text-neutral-600 hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                id="notification-password-tab" data-tabs-target="#notification-password" type="button"
                                role="tab" aria-controls="notification-password" aria-selected="false">
                                Notification Password
                            </button>
                        </li>
                    </ul>

                    <div id="default-tab-content">
                        <div class="hidden" id="edit-profile" role="tabpanel" aria-labelledby="edit-profile-tab">
                            {{-- <h6 class="text-base text-neutral-600 dark:text-neutral-200 mb-4">Profile Image</h6> --}}
                            <!-- Upload Image Start -->
                            {{-- <div class="mb-6 mt-4">
                                <div class="avatar-upload">
                                    <div class="avatar-edit absolute bottom-0 end-0 me-6 mt-4 z-[1] cursor-pointer">
                                        <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" hidden>
                                        <label for="imageUpload"
                                            class="w-8 h-8 flex justify-center items-center bg-primary-100 dark:bg-primary-600/25 text-primary-600 dark:text-primary-400 border border-primary-600 hover:bg-primary-100 text-lg rounded-full">
                                            <iconify-icon icon="solar:camera-outline" class="icon"></iconify-icon>
                                        </label>
                                    </div>
                                    <div class="avatar-preview">
                                        <div id="imagePreview">
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <!-- Upload Image End -->
                            @include('layout.feedback')


                            <form action="#">
                                <div class="grid grid-cols-1 sm:grid-cols-12 gap-x-6">

                                    <div class="col-span-12 sm:col-span-6">
                                        <div class="mb-5">
                                            <label for="full_name"
                                                class="inline-block font-semibold text-neutral-600 dark:text-neutral-200 text-sm mb-2">Full
                                                Name <span class="text-danger-600">*</span></label>
                                            <input type="text" class="form-control rounded-lg" id="full_name"
                                                placeholder="Enter Full Name" name="full_name"
                                                value="{{ @$user->full_name ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-span-12 sm:col-span-6">
                                        <div class="mb-5">
                                            <label for="name"
                                                class="inline-block font-semibold text-neutral-600 dark:text-neutral-200 text-sm mb-2">
                                                Name <span class="text-danger-600">*</span></label>
                                            <input type="text" class="form-control rounded-lg" id="name"
                                                placeholder="Enter name" name="name" value="{{ @$user->name ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-span-12 sm:col-span-6">
                                        <div class="mb-5">
                                            <label for="email"
                                                class="inline-block font-semibold text-neutral-600 dark:text-neutral-200 text-sm mb-2">Email
                                                <span class="text-danger-600">*</span></label>
                                            <input type="email" class="form-control rounded-lg" id="email"
                                                placeholder="Enter email address" name="email"
                                                value="{{ @$user->email ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-span-12 sm:col-span-6">
                                        <div class="mb-5">
                                            <label for="number"
                                                class="inline-block font-semibold text-neutral-600 dark:text-neutral-200 text-sm mb-2">Phone</label>
                                            <input type="email" class="form-control rounded-lg" id="number"
                                                placeholder="Enter phone number" name="phone_number"
                                                value="{{ @$user->phone_number ?? '' }}">
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="hidden" id="change-password" role="tabpanel" aria-labelledby="change-password-tab">
                            <form action="{{ route('changePassword') }}" method="POST">
                                @csrf
                                <div class="mb-5">
                                    <label for="current_password"
                                        class="inline-block font-semibold text-neutral-600 dark:text-neutral-200 text-sm mb-2">Current
                                        Password <span class="text-danger-600">*</span></label>
                                    <div class="relative">
                                        <input type="password" class="form-control rounded-lg" id="current_password"
                                            name="current_password" placeholder="Enter Current Password*" required>
                                        <span
                                            class="toggle-password ri-eye-line cursor-pointer absolute end-0 top-1/2 -translate-y-1/2 me-4 text-secondary-light"
                                            data-toggle="#current_password"></span>
                                    </div>
                                    @error('current_password')
                                        <span class="text-danger-600 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-5">
                                    <label for="password"
                                        class="inline-block font-semibold text-neutral-600 dark:text-neutral-200 text-sm mb-2">New
                                        Password <span class="text-danger-600">*</span></label>
                                    <div class="relative">
                                        <input type="password" class="form-control rounded-lg" id="password"
                                            name="password" placeholder="Enter New Password*" required>
                                        <span
                                            class="toggle-password ri-eye-line cursor-pointer absolute end-0 top-1/2 -translate-y-1/2 me-4 text-secondary-light"
                                            data-toggle="#password"></span>
                                    </div>
                                    @error('password')
                                        <span class="text-danger-600 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-5">
                                    <label for="password_confirmation"
                                        class="inline-block font-semibold text-neutral-600 dark:text-neutral-200 text-sm mb-2">Confirm
                                        Password <span class="text-danger-600">*</span></label>
                                    <div class="relative">
                                        <input type="password" class="form-control rounded-lg" id="password_confirmation"
                                            name="password_confirmation" placeholder="Confirm Password*" required>
                                        <span
                                            class="toggle-password ri-eye-line cursor-pointer absolute end-0 top-1/2 -translate-y-1/2 me-4 text-secondary-light"
                                            data-toggle="#password_confirmation"></span>
                                    </div>
                                </div>

                                <div class="flex justify-end">
                                    <button type="submit" class="btn btn-primary px-6 py-2 rounded-md font-semibold">
                                        Change Password
                                    </button>
                                </div>
                            </form>

                            @if (session('success'))
                                <div class="mt-4 p-4 bg-success-100 text-success-600 rounded-md">
                                    {{ session('success') }}
                                </div>
                            @endif
                        </div>
                        <div class="hidden" id="notification-password" role="tabpanel">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
