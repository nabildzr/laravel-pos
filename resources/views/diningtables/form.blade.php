@extends('layout.layout')
@php
    $title = empty($result) ? 'New Dining Table' : "Edit $result->name Table";
    $subTitle = 'Point of Sales';
    $script = ' 
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
                    {{ empty($result) ? 'Input New Table' : 'Edit Table' }}
                </h5>

            </div>

            <div class="card-body">
                @include('layout.feedback')
                <form
                    action="{{ empty($result) ? route('actionNewDiningTable') : route('actionEditDiningTable', "$result->id") }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf

                    @if (!empty($result))
                        @method('PUT')
                    @endif


                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-12">
                            <label class="form-label">Table Name</label>
                            <div class="icon-field">
                                <span class="icon">
                                    <iconify-icon icon="hugeicons:dining-table"></iconify-icon>
                                </span>
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name', empty($result) ? '' : $result->name) }}"
                                    placeholder="Enter table name" required>
                            </div>
                        </div>
                        <div class="col-span-12">
                            <label class="form-label">Status</label>
                            @if (!empty($result))
                                <div class="mb-2">
                                    <span
                                        class="inline-block px-3 py-1 rounded bg-blue-100 text-blue-800 font-semibold text-sm">
                                        Current: {{ ucfirst(str_replace('_', ' ', $result->status)) }}
                                    </span>
                                </div>
                            @endif
                            @php
                                $allStatuses = ['available', 'occupied', 'reserved', 'complete', 'out_of_service'];
                                $canChangeSpecial = auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'super_admin');
                                if (!empty($result)) {
                                    if ($canChangeSpecial) {
                                        // Admins can only change to complete, out_of_service, and available
                                        $statuses = ['available', 'out_of_service'];
                                    } else {
                                        // Regular users can only change to available, occupied, reserved
                                        $statuses = ['available', 'occupied', 'reserved'];
                                    }
                                    $selectedStatus = old('status', $result->status);
                                    $isLockedStatus = in_array($result->status, ['occupied', 'reserved', 'out_of_service', 'complete']);
                                } else {
                                    // On create, only available
                                    $statuses = ['available'];
                                    $selectedStatus = 'available';
                                    $isLockedStatus = false;
                                }
                            @endphp

                            <div class="icon-field">
                                <span class="icon">
                                    <iconify-icon icon="mdi:checkbox-marked-circle-outline"></iconify-icon>
                                </span>
                                <select name="status" class="form-control" required
                                    @if (!$canChangeSpecial && !empty($result) && in_array($result->status, ['occupied', 'reserved', 'out_of_service', 'completed'])) disabled @endif>
                                    @foreach ($statuses as $status)
                                        <option class="bg-neutral-500" value="{{ $status }}"
                                            {{ $selectedStatus == $status ? 'selected' : '' }}>
                                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                                        </option>
                                    @endforeach
                                </select>
                                @if (!$canChangeSpecial && $isLockedStatus)
                                    <input type="hidden" name="status" value="{{ $result->status }}">
                                @endif
                            </div>
                        </div>
                        <div class="col-span-12">
                            <label class="form-label">Capacity</label>
                            <div class="icon-field">
                                <span class="icon">
                                    <iconify-icon icon="mdi:account-group-outline"></iconify-icon>
                                </span>
                                <input type="number" name="capacity" class="form-control" min="1"
                                    value="{{ old('capacity', empty($result) ? '' : $result->capacity) }}"
                                    placeholder="Enter table capacity" required>
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
