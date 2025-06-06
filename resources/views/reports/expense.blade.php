@extends('layout.layout')
@php
    $title = 'Laporan Pengeluaran';
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
                    <h6 class="card-title mb-0 text-lg">Expenses Datatables</h6>
                </div>

                <form action="{{ route('reports.expenses.export') }}" method="GET"
                    class="flex flex-wrap items-end gap-3   px-6 pt-2 rounded-lg">
                    <div class="flex flex-col">
                        <label for="from"
                            class="text-sm font-medium text-neutral-700 dark:text-neutral-200 mb-1">From</label>
                        <input type="date" name="from" id="from"
                            class="form-input rounded-md border border-neutral-300 dark:border-neutral-600 focus:ring-primary-500 focus:border-primary-500 dark:bg-neutral-800 dark:text-white"
                            required>
                    </div>
                    <div class="flex flex-col">
                        <label for="to"
                            class="text-sm font-medium text-neutral-700 dark:text-neutral-200 mb-1">To</label>
                        <input type="date" name="to" id="to"
                            class="form-input rounded-md border border-neutral-300 dark:border-neutral-600 focus:ring-primary-500 focus:border-primary-500 dark:bg-neutral-800 dark:text-white"
                            required>
                    </div>
                    <button type="submit"
                        class="btn btn-success px-6 py-2 rounded-md font-semibold hover:bg-green-700 transition-colors mt-5 md:mt-0 gap-1 border border-neutral-300 bg-neutral-300 dark:border-neutral-600 dark:bg-neutral-800">
                        <iconify-icon icon="vscode-icons:file-type-excel" class="icon text-lg "></iconify-icon>
                        Export Excel
                    </button>
                    <button type="submit" formaction="{{ route('reports.expenses.export-pdf') }}"
                        class="btn btn-danger px-6 py-2 rounded-md font-semibold hover:bg-red-700 transition-colors mt-5 md:mt-0 gap-1 border border-neutral-300 bg-neutral-300 dark:border-neutral-600 dark:bg-neutral-800">
                        <iconify-icon icon="vscode-icons:file-type-pdf2" class="icon text-lg"></iconify-icon>
                        Export PDF
                    </button>
                </form>

                <div class="card-body">
                    @include('layout.feedback')

                    {{-- <a href="{{ route('newExpense') }}"
                        class="btn bg-primary-600 hover:bg-primary-700 text-white rounded-lg px-5 py-[11px] mb-5">Create
                        new
                        Expense</a> --}}
                    <table id="selection-table"
                        class="border border-neutral-200 dark:border-neutral-600 rounded-lg border-separate	">
                        <thead>
                            <tr>
                                <th scope="col" class="text-neutral-800 dark:text-white">
                                    <div class="form-check style-check flex items-center">
                                        <input class="form-check-input" id="select-all" type="checkbox">

                                        <label class="ms-2 form-check-label" for="serial">
                                            S.L
                                        </label>
                                    </div>
                                </th>
                                <th scope="col" class="text-neutral-800 dark:text-white">
                                    <div class="flex items-center gap-4">
                                        Expense Date
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                        </svg>
                                    </div>
                                </th>
                                <th scope="col" class="text-neutral-800 dark:text-white">
                                    <div class="flex items-center gap-2">
                                        Expense Category
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                        </svg>
                                    </div>
                                </th>
                                <th scope="col" class="text-neutral-800 dark:text-white">
                                    <div class="flex items-center gap-2">
                                        Amount
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                        </svg>
                                    </div>
                                </th>
                                <th scope="col" class="text-neutral-800 dark:text-white">
                                    <div class="flex items-center gap-2">
                                        Description
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                        </svg>
                                    </div>
                                </th>

                                <th scope="col" class="text-neutral-800 dark:text-white">
                                    <div class="flex items-center gap-2">
                                        Proof
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
                                        Approval
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                        </svg>
                                    </div>
                                </th>
                                <th scope="col" class="text-neutral-800 dark:text-white">
                                    <div class="flex items-center gap-2">
                                        Approved At
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                        </svg>
                                    </div>
                                </th>
                                <th scope="col" class="text-neutral-800 dark:text-white">
                                    <div class="flex items-center gap-2">
                                        Approved By
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                        </svg>
                                    </div>
                                </th>
                                <th scope="col" class="text-neutral-800 dark:text-white">
                                    <div class="flex items-center gap-2">
                                        Created At
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                        </svg>
                                    </div>
                                </th>
                                <th scope="col" class="text-neutral-800 dark:text-white">
                                    <div class="flex items-center gap-2">
                                        Updated At
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                        </svg>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($expenses as $expense)
                                <tr>
                                    <td>
                                        <div class="form-check style-check flex items-center">
                                            <input type="checkbox" name="selected[]" value="{{ $expense->id }}"
                                                class="form-check-input">
                                            <label class="ms-2 form-check-label">
                                                {{ $expense->id }}
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <h6 class="text-base mb-0 font-bold grow">{{ $expense->date }}</h6>
                                    </td>

                                    <td>
                                        <h6 class="text-base mb-0 font-medium grow">
                                            {{ $expense->expenseCategory->name }}</h6>
                                    </td>
                                    <td>
                                        <div class="items-center w-48">
                                            <p class="text-base mb-0 font-medium grow">{{ $expense->amount }}</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="items-center w-48">
                                            <textarea class="text-base mb-0 font-medium grow dark:bg-neutral-600 rounded-xl">{{ $expense->description }}</textarea>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex items-center">
                                            @if ($expense->proof)
                                                <img src="{{ asset('storage/' . $expense->proof) }}" alt=""
                                                    class="shrink-0 me-3 rounded-lg w-10">
                                            @else
                                                <img src="{{ asset('') }}" alt=""
                                                    class="shrink-0 me-3 rounded-lg w-10 bg-white">
                                            @endif
                                        </div>

                                    </td>
                                    <td>
                                        <div class="items-center w-48">
                                            <p class="text-base mb-0 font-medium grow">{{ $expense->user->name }}</p>
                                        </div>


                                    </td>
                                    <td>
                                        <div class="flex space-x-2">
                                            @if ($expense->status == 'approved')
                                                <span
                                                    class="bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400 border border-success-600 px-6 py-1.5 rounded font-medium text-sm">Approved</span>
                                            @elseif($expense->status == 'rejected')
                                                <span
                                                    class="bg-neutral-200 dark:bg-neutral-600 text-neutral-600 border border-neutral-400 px-6 py-1.5 rounded font-medium text-sm">Not
                                                    Approved</span>
                                            @else
                                                <span
                                                    class="bg-warning-100 dark:bg-warning-600/25 text-warning-600 dark:text-warning-400 border border-warning-600 px-6 py-1.5 rounded font-medium text-sm">Pending</span>
                                            @endif

                                        </div>
                                    </td>
                                    <td>
                                        <div class="items-center w-48">
                                            @if ($expense->approved_at)
                                                <p class="text-base mb-0 font-medium grow">{{ $expense->approved_at }}</p>
                                            @else
                                                <span class="text-warning-600 font-medium">Waiting Approval</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="items-center w-48">
                                            @if ($expense->approved_by)
                                                <p class="text-base mb-0 font-medium grow">{{ $expense->approver->name }}
                                                </p>
                                            @else
                                                <span class="text-warning-600 font-medium">-</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="items-center w-48">
                                            <p class="text-base mb-0 font-medium grow">{{ $expense->created_at }}</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="items-center w-48">
                                            <p class="text-base mb-0 font-medium grow">{{ $expense->updated_at }}</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
