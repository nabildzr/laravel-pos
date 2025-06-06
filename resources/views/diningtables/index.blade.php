@extends('layout.layout')
@php
    $title = 'Dining Table';
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
                    <h6 class="card-title mb-0 text-lg">Reservation Table Datatables</h6>
                </div>

                {{-- <form method="POST" action="{{ route('printExpenses') }}" target="_blank">
                    @csrf
                    <button type="submit" class="btn btn-primary mb-3">Print Selected</button>

                    <form method="POST" action="{{ route('importExpenses') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="file" accept=".csv,.xlsx" required>
                        <button type="submit" class="btn btn-info mb-3">Import</button>
                    </form>
                    <form method="POST" action="{{ route('exportExpenses') }}">
                    @csrf
                    <input type="hidden" name="selected" id="export-selected">
                    <button type="submit" class="btn btn-success mb-3">Export Selected</button>
                </form> --}}

                <div class="card-body">
                    @include('layout.feedback')

                    <div class="flex space-x-2">
                          <a href="{{ route('newDiningTable') }}"
                              class="btn bg-primary-600 hover:bg-primary-700 text-white rounded-lg px-5 py-[11px] mb-5">Create new
                              Table</a>
                          <a href="{{ route('reservations.index') }}"
                              class="btn bg-primary-600 hover:bg-primary-700 text-white rounded-lg px-5 py-[11px] mb-5">Look Reservations</a>
                      </div>
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
                                    <div class="flex items-center gap-2">
                                        Name
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                        </svg>
                                    </div>
                                </th>
                                <th scope="col" class="text-neutral-800 dark:text-white">
                                    <div class="flex items-center gap-2">
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
                                        Capacity
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                        </svg>
                                    </div>
                                </th>
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
                                        Action
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tables as $table)
                                <tr>
                                    <td>
                                        <div class="form-check style-check flex items-center">
                                            <input type="checkbox" name="selected[]" value="{{ $table->id }}"
                                                class="form-check-input">
                                            <label class="ms-2 form-check-label">
                                                {{ $table->id }}
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <h6 class="text-base mb-0 font-bold grow">{{ $table->name }}</h6>
                                    </td>
                                    <td class="flex justify-center">

                                        <div>
                                            <span
                                                class="mb-0 grow px-8 py-1.5 rounded-full font-medium text-base
                                                    @if ($table->status == 'available') bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400
                                                    @elseif($table->status == 'occupied')
                                                        bg-warning-100 dark:bg-warning-600/25 text-warning-600 dark:text-warning-400
                                                    @elseif($table->status == 'reserved')
                                                        bg-info-100 dark:bg-info-600/25 text-info-600 dark:text-info-400
                                                    @elseif($table->status == 'out_of_service')
                                                        bg-danger-100 dark:bg-danger-600/25 text-danger-600 dark:text-danger-400 @endif
                                                ">
                                                {{ $table->status == 'out_of_service' ? 'out of service' : $table->status }}
                                            </span>
                                        </div>

                                    </td>
                                    <td>
                                        <div class="items-center w-48">
                                            <p class="text-base mb-0 font-medium grow">{{ $table->capacity }}</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="items-center w-48">
                                            <p class="text-base mb-0 font-medium grow">{{ $table->user->name }}</p>
                                        </div>


                                    </td>
                                    <td class="">
                                        <a href="{{ url("/tables/edit/$table->id") }}"
                                            class="w-8 h-8 bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400 rounded-full inline-flex items-center justify-center">
                                            <iconify-icon icon="lucide:edit"></iconify-icon>
                                        </a>
                                        <a data-modal-target="delete-modal-{{ $table->id }}"
                                            data-modal-toggle="delete-modal-{{ $table->id }}"
                                            class="w-8 h-8 bg-danger-100 dark:bg-danger-600/25 text-danger-600 dark:text-danger-400 rounded-full inline-flex items-center justify-center">
                                            <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                        </a>
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

    <script>
        document.getElementById('select-all').addEventListener('change', function() {
            let checked = this.checked;
            document.querySelectorAll('.select-item').forEach(cb => cb.checked = checked);
        });

        document.querySelector('form[action="{{ route('exportExpenses') }}"]').addEventListener('submit', function(e) {
            let selected = [];
            document.querySelectorAll('input[name="selected[]"]:checked').forEach(cb => selected.push(cb.value));
            document.getElementById('export-selected').value = selected.join(',');
        });
    </script>

    @foreach ($tables as $table)
        <x-confirm-delete-modal :modalId="'delete-modal-' . $table->id" :route="route('actionDeleteDiningTable', $table->id)" />
    @endforeach
@endsection
