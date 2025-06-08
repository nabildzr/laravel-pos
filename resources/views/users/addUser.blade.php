@extends('layout.layout')
@php
    $isEdit = isset($user);
    $title = $isEdit ? 'Edit User' : 'Add User';
    $subTitle = $isEdit ? 'Edit User' : 'Add User';
    $script = '<script>
        // ================== Image Upload Js Start ===========================
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
        // ================== Image Upload Js End ===========================
    </script>';
@endphp

@section('content')
    <div class="card h-full p-0 rounded-xl border-0 overflow-hidden">
        <div class="card-body p-6">
            <div class="grid grid-cols-1 lg:grid-cols-12 justify-center">
                <div class="col-span-12 lg:col-span-10 xl:col-span-8 2xl:col-span-6 2xl:col-start-4">
                    <div class="card border border-neutral-200 dark:border-neutral-600">
                        <div class="card-body">
                            <h6 class="text-base text-neutral-600 dark:text-neutral-200 mb-4">
                                {{ $isEdit ? 'Update User' : 'Create New User' }}</h6>



                            <form action="{{ $isEdit ? route('updateUser', $user->id) : route('storeUser') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @if ($isEdit)
                                    @method('PUT')
                                @endif

                                <!-- Upload Image Start -->
                                <div class="mb-6 mt-4">
                                    <div class="avatar-upload">
                                        <div class="avatar-edit absolute bottom-0 end-0 me-6 mt-4 z-[1] cursor-pointer ">
                                            <input type='file' id="imageUpload" name="profile_image"
                                                accept=".png, .jpg, .jpeg" hidden>
                                            <label for="imageUpload"
                                                class="w-8 h-8 flex justify-center items-center bg-primary-50 dark:bg-primary-600/25 text-primary-600 dark:text-primary-400 border border-primary-600 hover:bg-primary-100 text-lg rounded-full">
                                                <iconify-icon icon="solar:camera-outline" class="icon"></iconify-icon>
                                            </label>
                                        </div>
                                        <div class="avatar-preview">
                                            <div id="imagePreview"
                                                style="{{ $isEdit && isset($user->profile_image) ? 'background-image: url(' . asset('storage/' . $user->profile_image) . ')' : '' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Upload Image End -->

                                <div class="mb-5">
                                    <label for="name"
                                        class="inline-block font-semibold text-neutral-600 dark:text-neutral-200 text-sm mb-2">Full
                                        Name <span class="text-danger-600">*</span></label>
                                    <input type="text" class="form-control rounded-lg" id="name" name="name"
                                        value="{{ $isEdit ? $user->name : old('name') }}" placeholder="Enter Full Name"
                                        required>
                                    @error('name')
                                        <span class="text-danger-600 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-5">
                                    <label for="email"
                                        class="inline-block font-semibold text-neutral-600 dark:text-neutral-200 text-sm mb-2">Email
                                        <span class="text-danger-600">*</span></label>
                                    <input type="email" class="form-control rounded-lg" id="email" name="email"
                                        value="{{ $isEdit ? $user->email : old('email') }}"
                                        placeholder="Enter email address" required>
                                    @error('email')
                                        <span class="text-danger-600 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-5">
                                    <label for="phone_number"
                                        class="inline-block font-semibold text-neutral-600 dark:text-neutral-200 text-sm mb-2">Phone</label>
                                    <input type="text" class="form-control rounded-lg" id="phone_number"
                                        name="phone_number"
                                        value="{{ $isEdit ? $user->phone_number : old('phone_number') }}"
                                        placeholder="Enter phone number">
                                    @error('phone_number')
                                        <span class="text-danger-600 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                @if ($isEdit && isset($user) && $user->id == 1)
    <div class="mb-5">
        <label class="inline-block font-semibold text-neutral-600 dark:text-neutral-200 text-sm mb-2">
            Role
        </label>
        <input type="text" class="form-control rounded-lg bg-neutral-100 dark:bg-neutral-700 text-neutral-600 dark:text-neutral-200" value="Super Admin" disabled>
        <input type="hidden" name="role" value="super_admin">
    </div>
@else
    {{-- for other users or new user --}}
    <div class="mb-5">
        <label for="role" class="inline-block font-semibold text-neutral-600 dark:text-neutral-200 text-sm mb-2">Role
            <span class="text-danger-600">*</span></label>
        <select class="form-control rounded-lg form-select" id="role" name="role" required>
            <option class="dark:bg-neutral-700" value="">Select Role</option>
            <option class="dark:bg-neutral-700" value="operator"
                {{ ($isEdit && $user->role === 'operator') || old('role') === 'operator' ? 'selected' : '' }}>
                Operator</option>
                
            @if (Auth::check() && Auth::user()->role === 'super_admin')
                <option class="dark:bg-neutral-700" value="admin"
                    {{ ($isEdit && $user->role === 'admin') || old('role') === 'admin' ? 'selected' : '' }}>
                    Admin
                </option>
            @endif
            
            @if (Auth::check() && Auth::user()->role === 'super_admin' && Auth::id() == 1)
                <option class="dark:bg-neutral-700" value="super_admin"
                    {{ ($isEdit && $user->role === 'super_admin') || old('role') === 'super_admin' ? 'selected' : '' }}>
                    Super Admin</option>
            @endif
        </select>
        @error('role')
            <span class="text-danger-600 text-sm">{{ $message }}</span>
        @enderror
    </div>
@endif

                                {{-- @if ($isEdit && isset($user) && $user->id == 1)
                                    <div class="mb-5">
                                        <label
                                            class="inline-block font-semibold text-neutral-600 dark:text-neutral-200 text-sm mb-2">
                                            Role
                                        </label>
                                        <input type="text"
                                            class="form-control rounded-lg bg-neutral-100 dark:bg-neutral-700 text-neutral-600 dark:text-neutral-200"
                                            value="Super Admin" disabled>
                                        <input type="hidden" name="role" value="super_admin">
                                    </div>
                                @else
                                    <div class="mb-5">
                                        <label for="role"
                                            class="inline-block font-semibold text-neutral-600 dark:text-neutral-200 text-sm mb-2">Role
                                            <span class="text-danger-600">*</span></label>
                                        <select class="form-control rounded-lg form-select" id="role" name="role"
                                            required>
                                            <option class="dark:bg-neutral-700" value="">Select Role</option>
                                            <option class="dark:bg-neutral-700" value="operator"
                                                {{ ($isEdit && $user->role === 'operator') || old('role') === 'operator' ? 'selected' : '' }}>
                                                Operator</option>
                                            @if (Auth::user()->role === 'super_admin')
                                                <option class="dark:bg-neutral-700" value="admin"
                                                    {{ ($isEdit && $user->role === 'admin') || old('role') === 'admin' ? 'selected' : '' }}>
                                                    Admin
                                                </option>
                                            @endif
                                        

                                            @if (Auth::user()->role === 'super_admin' && Auth::id() == 1)
                                                <option class="dark:bg-neutral-700" value="super_admin"
                                                    {{ ($isEdit && $user->role === 'super_admin') || old('role') === 'super_admin' ? 'selected' : '' }}>
                                                    Super Admin</option>
                                            @endif
                                        </select>
                                        @error('role')
                                            <span class="text-danger-600 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endif --}}

                                <div class="mb-5">
                                    <label for="is_active"
                                        class="inline-block font-semibold text-neutral-600 dark:text-neutral-200 text-sm mb-2">Status</label>
                                    <select class="form-control rounded-lg form-select" id="is_active" name="is_active">
                                        <option value="1"
                                            {{ ($isEdit && $user->is_active) || old('is_active') === '1' ? 'selected' : '' }}>
                                            Active</option>
                                        <option value="0"
                                            {{ ($isEdit && !$user->is_active) || old('is_active') === '0' ? 'selected' : '' }}>
                                            Inactive</option>
                                    </select>
                                    @error('is_active')
                                        <span class="text-danger-600 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>


                                @if (!$isEdit)
                                    {{-- Form input password untuk user baru --}}
                                    <div class="mb-5">
                                        <label for="password"
                                            class="inline-block font-semibold text-neutral-600 dark:text-neutral-200 text-sm mb-2">Password
                                            <span class="text-danger-600">*</span></label>
                                        <input type="password" class="form-control rounded-lg" id="password"
                                            name="password" placeholder="Enter password" required>
                                        @error('password')
                                            <span class="text-danger-600 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-5">
                                        <label for="password_confirmation"
                                            class="inline-block font-semibold text-neutral-600 dark:text-neutral-200 text-sm mb-2">Confirm
                                            Password <span class="text-danger-600">*</span></label>
                                        <input type="password" class="form-control rounded-lg" id="password_confirmation"
                                            name="password_confirmation" placeholder="Confirm password" required>
                                    </div>
                                @else
                                    {{-- Form input password untuk update user (hanya untuk super_admin) --}}
                                    @if (Auth::user()->role === 'super_admin')
                                        <div class="mb-5">
                                            <label for="password"
                                                class="inline-block font-semibold text-neutral-600 dark:text-neutral-200 text-sm mb-2">New
                                                Password
                                                <span class="text-secondary-light">(leave blank to keep
                                                    current)</span></label>
                                            <input type="password" class="form-control rounded-lg" id="password"
                                                name="password" placeholder="Enter new password">
                                            @error('password')
                                                <span class="text-danger-600 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="mb-5">
                                            <label for="password_confirmation"
                                                class="inline-block font-semibold text-neutral-600 dark:text-neutral-200 text-sm mb-2">Confirm
                                                New Password</label>
                                            <input type="password" class="form-control rounded-lg"
                                                id="password_confirmation" name="password_confirmation"
                                                placeholder="Confirm new password">
                                        </div>
                                    @endif
                                @endif

                                <div class="flex items-center justify-center gap-3">
                                    <a href="{{ route('usersList') }}"
                                        class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-base px-14 py-[11px] rounded-lg">
                                        Cancel
                                    </a>
                                    <button type="submit"
                                        class="btn btn-primary border border-primary-600 text-base px-14 py-3 rounded-lg">
                                        {{ $isEdit ? 'Update' : 'Save' }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
