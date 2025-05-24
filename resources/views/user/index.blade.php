@extends('layout.layout')
@php
    $title = 'Users';
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
                    <h6 class="card-title mb-0 text-lg">Users Datatables</h6>
                </div>


                <div class="card-body">
                    @include('layout.feedback')

                    <a href="{{ 
                    // route('newMember')
                     }}"
                        class="btn bg-primary-600 hover:bg-primary-700 text-white rounded-lg px-5 py-[11px] mb-5">Create new
                        User</a>
                    <table id="selection-table"
                        class="border border-neutral-200 dark:border-neutral-600 rounded-lg border-separate	">
                        <thead>
                            <tr>
                                <th scope="col" class="text-neutral-800 dark:text-white">
                                    <div class="form-check style-check flex items-center">
                                        <input class="form-check-input" id="serial" type="checkbox">
                                        <label class="ms-2 form-check-label" for="serial">
                                            S.L
                                        </label>
                                    </div>
                                </th>

                                <th scope="col" class="text-neutral-800 dark:text-white">
                                    <div class="flex items-center gap-2">
                                        User Name
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
                                        Phone Number
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                        </svg>
                                    </div>
                                </th>
                                <th scope="col" class="text-neutral-800 dark:text-white">
                                    <div class="flex items-center gap-2">
                                        Email
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                        </svg>
                                    </div>
                                </th>
                                <th scope="col" class="text-neutral-800 dark:text-white">
                                    <div class="flex items-center gap-2">
                                        Address
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                        </svg>
                                    </div>
                                </th>
                                <th scope="col" class="text-neutral-800 dark:text-white">
                                    <div class="flex items-center gap-2">
                                        Action
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($members as $member)
                                <tr>
                                    <td>
                                        <div class="form-check style-check flex items-center">
                                            <input class="form-check-input" type="checkbox">
                                            <label class="ms-2 form-check-label">
                                                {{ $member->id }}
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex items-center">
                                            @if ($member->image)
                                                <img src="{{ asset('storage/' . $member->image) }}" alt=""
                                                    class="shrink-0 me-3 rounded-lg w-10">
                                            @else
                                                <img src="{{ asset('') }}" alt=""
                                                    class="shrink-0 me-3 rounded-lg w-10 bg-white">
                                            @endif
                                            <h6 class="text-base mb-0 font-bold grow">{{ $member->name }}</h6>
                                        </div>
                                    </td>

                                    <td>
                                        <h6
                                            class="text-base
                                            mb-0 font-medium grow">
                                            {{ $member->user->name }}</h6>
                                    </td>
                                    <td>
                                        <div class="flex items-center">

                                            <h6 class="text-base mb-0 font-medium grow">{{ $member->phone_number }}
                                            </h6>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex items-center">

                                            <h6 class="text-base mb-0 font-medium grow">{{ $member->email }}
                                            </h6>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex items-center">

                                            <h6 class="text-base mb-0 font-medium grow">{{ $member->address }}
                                            </h6>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)"
                                            class="w-8 h-8 bg-primary-50 dark:bg-primary-600/10 text-primary-600 dark:text-primary-400 rounded-full inline-flex items-center justify-center">
                                            <iconify-icon icon="iconamoon:eye-light"></iconify-icon>
                                        </a>
                                        <a href="{{ url("/member/edit/$member->id") }}"
                                            class="w-8 h-8 bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400 rounded-full inline-flex items-center justify-center">
                                            <iconify-icon icon="lucide:edit"></iconify-icon>
                                        </a>

                                        @if (!in_array(strtolower($member->name), ['cash', 'transfer']))
                                            <a data-modal-target="delete-modal-{{ $member->id }}"
                                                data-modal-toggle="delete-modal-{{ $member->id }}"
                                                class="w-8 h-8 bg-danger-100 dark:bg-danger-600/25 text-danger-600 dark:text-danger-400 rounded-full inline-flex items-center justify-center">
                                                <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                        @endif
                                    </td>
                                </tr>

                                <x-confirm-delete-modal :modalId="'delete-modal-' . $member->id" :route="route('actionDeleteMember', $member->id)" />
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
