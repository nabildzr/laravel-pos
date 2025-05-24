@extends('layout.layout')
@php
    $title = 'Transaction';
    $subTitle = 'Point of Sales';
    $script = '<script src="' . asset('assets/js/data-table.js') . '"></script>
    <script>
        $(".remove-button").on("click", function() {
            $(this).closest(".alert").addClass("hidden")
        });
    </script>
    
    <script>
        document.getElementById("closeModal").addEventListener("click", function() {
            const modal = this.closest(".modal");
            if (modal) {
                modal.classList.add("hidden");
            }
        });
    </script>

    
    
    ';
@endphp

@section('content')
    <div class="grid grid-cols-12">
        <div class="col-span-12">
            <div class="card border-0 overflow-hidden">
                <div class="card-header">
                    <h6 class="card-title mb-0 text-lg">Transaction Datatables</h6>
                </div>


                <div class="card-body">
                    @include('layout.feedback')
                    <table id="selection-table"
                        class="border border-neutral-200 dark:border-neutral-600 rounded-lg border-separate	">
                        <thead>
                            <tr>
                                {{-- <th scope="col" class="text-neutral-800 dark:text-white">
                                    <div class="form-check style-check flex items-center">
                                        <input class="form-check-input" id="serial" type="checkbox">
                                        <label class="ms-2 form-check-label" for="serial">
                                            S.L
                                        </label>
                                    </div>
                                </th> --}}
                                <th scope="col" class="text-neutral-800 dark:text-white">
                                    <div class="flex items-center gap-2">
                                        ID
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                        </svg>
                                    </div>
                                </th>
                                <th scope="col" class="text-neutral-800 dark:text-white">
                                    <div class="flex items-center gap-2">
                                        Customer
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                        </svg>
                                    </div>
                                </th>
                                <th scope="col" class="text-neutral-800 dark:text-white">
                                    <div class="flex items-center gap-2">
                                        Total Amount
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                        </svg>
                                    </div>
                                </th>
                                <th scope="col" class="text-neutral-800 dark:text-white justify-center flex">
                                    <div class="flex items-center gap-2 justify-center">
                                        Status
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                        </svg>
                                    </div>
                                </th>
                                <th scope="col" class="text-neutral-800 dark:text-white">
                                    <div class="flex items-center gap-2">
                                        Payment Method
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                        </svg>
                                    </div>
                                </th>

                                <th scope="col" class="text-neutral-800 dark:text-white">
                                    <div class="flex items-center gap-2">
                                        Cashier
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
                            @foreach ($transactions as $expense)
                                <tr>
                                    {{-- <td>
                                        <div class="form-check style-check flex items-center">
                                            <input class="form-check-input" type="checkbox">
                                            <label class="ms-2 form-check-label">
                                                {{ $expense->id }}
                                            </label>
                                        </div>
                                    </td> --}}
                                    <td>
                                        <h6 class="text-base mb-0 font-bold grow">{{ $expense->id ?? '0' }}
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class="text-base mb-0 font-bold grow">{{ $expense->member->name ?? 'Customer' }}
                                        </h6>
                                    </td>
                                    <td>
                                        <p class="text-base mb-0 font-medium grow">
                                         Rp   {{ number_format($expense->total_amount, 0, '.', '.') }}</p>
                                    </td>
                                    <td class="flex justify-center">

                                        <div>
                                            <span
                                                class="mb-0 grow px-8 py-1.5 rounded-full font-medium text-base
                                                    @if ($expense->status == 'paid') bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400
                                                    @elseif($expense->status == 'pending')
                                                        bg-warning-100 dark:bg-warning-600/25 text-warning-600 dark:text-warning-400
                                                    @else
                                                        bg-danger-100 dark:bg-danger-600/25 text-danger-600 dark:text-danger-400 @endif
                                                ">
                                                {{ $expense->status }}
                                            </span>
                                        </div>

                                    </td>
                                    <td>
                                        <div class="items-center w-48">
                                            <p class="text-base mb-0 font-medium grow">{{ $expense->paymentMethod->name }}
                                            </p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="items-center w-48">
                                            <p class="text-base mb-0 font-medium grow">{{ $expense->user->name }}</p>
                                        </div>
                                    </td>
                                    <td class="">
                                        @if ($expense->status == 'paid' || $expense->status === "cancelled")
                                            <a href="{{ url('/invoice/' . $expense->id) }}"
                                                class="w-8 h-8 bg-primary-50 dark:bg-primary-600/10 text-primary-600 dark:text-primary-400 rounded-full inline-flex items-center justify-center">
                                                <iconify-icon icon="iconamoon:eye-light"></iconify-icon>
                                            </a>
                                        @endif

                                        @if ($expense->status === 'pending' )
                                            <a href="{{ url('/transaction/' . $expense->id . '/payment') }}"
                                                class="w-8 h-8 bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400 rounded-full inline-flex items-center justify-center">
                                                <iconify-icon icon="lucide:edit"></iconify-icon>
                                            </a>
                                        @endif
                                    </td>
                                </tr>

                                <x-confirm-delete-modal :modalId="'delete-modal-' . $expense->id" :route="route('actionDeleteExpense', $expense->id)" />
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
