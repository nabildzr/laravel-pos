@extends('layout.layout')
@php
    $title = 'View User Profile';
    $subTitle = 'User Profile';
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
                                alt="Profile Image" class="border br-white border-width-2-px rounded-full object-fit-cover mx-auto" style="width: 200px; height: 200px; object-fit: cover;">
                        @else
                            <img src="{{ asset('assets/images/user-grid/user-grid-img14.png') }}" alt="Profile Image"
                                class="border br-white border-width-2-px w-200-px h-[200px] rounded-full object-fit-cover mx-auto">
                        @endif
                        <h6 class="mb-0 mt-4">{{ $user->name ?? 'Not Found' }}</h6>
                        <span class="text-secondary-light mb-4">{{ $user->email ?? 'Not Found' }}</span>
                        <p class="my-3">
                            <span
                                class="px-3 py-1 rounded-full text-success-600 dark:text-success-600
                                    {{ $user->is_active 
                                        ? 'bg-success-100 ' 
                                        : 'bg-neutral-200 ' }}">
                                {{ $user->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </p>
                        <p class="my-3">
                            <span class="px-3 py-1 rounded-full bg-primary-100 text-primary-600 dark:text-primary-600">
                                {{ ucfirst($user->role ?? 'User') }}
                            </span>
                        </p>
                    </div>
                    <div class="mt-6">
                        <h6 class="text-xl mb-4">Personal Info</h6>
                        <ul>
                            <li class="flex items-center gap-1 mb-3">
                                <span class="w-[30%] text-base font-semibold text-neutral-600 dark:text-neutral-200"> Full
                                    Name</span>
                                <span class="w-[70%] text-secondary-light font-medium">:
                                    {{ $user->full_name ?? 'Not Available' }}</span>
                            </li>
                            <li class="flex items-center gap-1 mb-3">
                                <span class="w-[30%] text-base font-semibold text-neutral-600 dark:text-neutral-200">
                                    Email</span>
                                <span class="w-[70%] text-secondary-light font-medium">:
                                    {{ $user->email ?? 'Not Available' }}</span>
                            </li>
                            <li class="flex items-center gap-1 mb-3">
                                <span class="w-[30%] text-base font-semibold text-neutral-600 dark:text-neutral-200"> Phone
                                    Number</span>
                                <span class="w-[70%] text-secondary-light font-medium">:
                                    {{ $user->phone_number ?? 'Not Available' }}</span>
                            </li>
                            <li class="flex items-center gap-1 mb-3">
                                <span class="w-[30%] text-base font-semibold text-neutral-600 dark:text-neutral-200">
                                    Joined On</span>
                                <span class="w-[70%] text-secondary-light font-medium">:
                                    {{ $user->created_at ? $user->created_at->format('d M Y') : 'Not Available' }}</span>
                            </li>
                        </ul>
                    </div>

                    <div class="mt-6 flex justify-center">
                        <a href="{{ url('/users/users-list') }}" class="btn btn-primary px-5 py-2">
                            Back to Users List
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-span-12 lg:col-span-8">
            <div class="card h-full border-0">
                <div class="card-header  dark:border-neutral-600 rounded-xl bg-white dark:bg-neutral-700 py-4 px-6">
                    <h5 class="card-title mb-0">User Activity</h5>
                </div>
                <div class="card-body p-6">
                    <div class="mb-5">
                        <h6 class="mb-3">Recent Logins</h6>
                        <div class="overflow-x-auto">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Date & Time</th>
                                        <th>IP Address</th>
                                        <th>Device</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($loginHistory) && count($loginHistory) > 0)
                                        @foreach ($loginHistory as $login)
                                            <tr>
                                                <td>{{ $login->created_at->format('d M Y, h:i A') }}</td>
                                                <td>{{ $login->ip_address }}</td>
                                                <td>{{ \Illuminate\Support\Str::limit($login->user_agent, 30) }}</td>
                                                <td>
                                                    <span
                                                        class="px-2 py-1 rounded-full text-xs {{ $login->status === 'success' ? 'bg-success-100 text-success-600' : 'bg-danger-100 text-danger-600' }}">
                                                        {{ ucfirst($login->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center">No login history available</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
