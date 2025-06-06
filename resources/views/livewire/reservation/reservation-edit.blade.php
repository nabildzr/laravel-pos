<div class="md:col-span-6 col-span-12">
    <div class="card border-0">
        <div class="card-header">
            <h5 class="text-lg font-semibold mb-0">Edit Reservation</h5>
        </div>

        <div class="card-body">
            @include('layout.feedback')

            @if (session()->has('success'))
                <div class="alert alert-success mb-3">{{ session('success') }}</div>
            @endif

            <form wire:submit.prevent='save'>
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-12">
                        <label class="form-label">Nama Kontak</label>
                        <div class="icon-field">
                            <span class="icon">
                                <iconify-icon icon="mdi:account"></iconify-icon>
                            </span>
                            <input type="text" wire:model='contact_name' name="contact_name"
                                class="form-control" placeholder="Masukkan nama">
                        </div>
                        @error('contact_name')
                            <div class="text-red-500 text-xs">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-span-12">
                        <label class="form-label">No. Telepon Kontak</label>
                        <div class="icon-field">
                            <span class="icon">
                                <iconify-icon icon="mdi:phone"></iconify-icon>
                            </span>
                            <input type="text" wire:model='contact_phone' name="contact_phone"
                                class="form-control" placeholder="Masukkan nomor telepon">
                        </div>
                        @error('contact_phone')
                            <div class="text-red-500 text-xs">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-span-12">
                        <label class="form-label">Email Kontak</label>
                        <div class="icon-field">
                            <span class="icon">
                                <iconify-icon icon="mdi:email"></iconify-icon>
                            </span>
                            <input type="email" wire:model='contact_email' name="contact_email" class="form-control"
                                placeholder="Masukkan email (opsional)">
                        </div>
                        @error('contact_email')
                            <div class="text-red-500 text-xs">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-span-12">
                        <label class="form-label">Alamat Kontak</label>
                        <div class="icon-field">
                            <span class="icon">
                                <iconify-icon icon="mdi:address-marker"></iconify-icon>
                            </span>
                            <input type="text" wire:model='contact_address' name="contact_address" class="form-control"
                                placeholder="Masukkan address (opsional)">
                        </div>
                        @error('contact_address')
                            <div class="text-red-500 text-xs">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <label class="form-label">Tanggal Reservasi</label>
                        <div class="icon-field">
                            <span class="icon">
                                <iconify-icon icon="mdi:calendar"></iconify-icon>
                            </span>
                            <input type="date" wire:model='reservation_date' name="reservation_date"
                                class="form-control">
                        </div>
                        @error('reservation_date')
                            <div class="text-red-500 text-xs">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <label class="form-label">Waktu Reservasi</label>
                        <div class="icon-field">
                            <span class="icon">
                                <iconify-icon icon="mdi:clock-outline"></iconify-icon>
                            </span>
                            <input type="time" wire:model='reservation_time' name="reservation_time"
                                class="form-control" >
                        </div>
                        @error('reservation_time')
                            <div class="text-red-500 text-xs">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-span-12">
                        <label class="form-label">Jumlah DP</label>
                        <div class="icon-field">
                            <span class="icon">
                                <iconify-icon icon="mdi:account-group-outline"></iconify-icon>
                            </span>
                            <input type="number" wire:model='down_payment_amount' name="down_payment_amount" min="0"
                                class="form-control" placeholder="Masukkan Jumlah Down Payment">
                        </div>
                        @error('down_payment_amount')
                            <div class="text-red-500 text-xs">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-span-12">
                        <label class="form-label">Jumlah Tamu</label>
                        <div class="icon-field">
                            <span class="icon">
                                <iconify-icon icon="mdi:account-group-outline"></iconify-icon>
                            </span>
                            <input type="number" wire:model='guest_count' name="guest_count" min="1"
                                class="form-control" placeholder="Masukkan jumlah tamu">
                        </div>
                        @error('guest_count')
                            <div class="text-red-500 text-xs">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- @if ($status === 'completed')
                        <div class="col-span-12">
                            <label class="form-label">Status Reservasi</label>
                            <div class="icon-field">
                                <span class="icon">
                                    <iconify-icon icon="mdi:check-circle-outline"></iconify-icon>
                                </span>
                                <select name="status" class="form-control" disabled>
                                    <option class="dark:bg-neutral-700" value="reserved" @if($status=='reserved') selected @endif>Reserved</option>
                                    <option class="dark:bg-neutral-700" value="occupied" @if($status=='occupied') selected @endif>Occupied</option>
                                    <option class="dark:bg-neutral-700" value="cancelled" @if($status=='cancelled') selected @endif>Cancelled</option>
                                    <option class="dark:bg-neutral-700" value="completed" @if($status=='completed') selected @endif>Completed</option>
                                </select>
                            </div>
                            @error('status')
                                <div class="text-red-500 text-xs">{{ $message }}</div>
                            @enderror
                        </div>
                    @else
                        <div class="col-span-12">
                            <label class="form-label">Status Reservasi</label>
                            <div class="icon-field">
                                <span class="icon">
                                    <iconify-icon icon="mdi:check-circle-outline"></iconify-icon>
                                </span>
                                <select wire:model="status" name="status" class="form-control">
                                    <option class="dark:bg-neutral-700" value="reserved">Reserved</option>
                                    <option class="dark:bg-neutral-700" value="occupied">Occupied</option>
                                    <option class="dark:bg-neutral-700" value="cancelled">Cancelled</option>
                                    <option class="dark:bg-neutral-700" value="completed">Completed</option>
                                </select>
                            </div>
                            @error('status')
                                <div class="text-red-500 text-xs">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif --}}

                    {{-- <div class="col-span-12">
                        <label class="form-label">Pilih Meja</label>
                        <div class="grid grid-cols-2 gap-2">
                            @foreach ($tables as $table)
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" wire:model="selected_tables" name="selected_tables[]"
                                        value="{{ $table->dining_table_id }}">
                                    <span>{{ $table->table_name }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('selected_tables')
                            <div class="text-red-500 text-xs">{{ $message }}</div>
                        @enderror
                    </div> --}}

<div class="col-span-12">
    <label class="form-label">Meja</label>
    <div class="grid grid-cols-2 gap-2">
        @if($status === 'completed' || $status === 'cancelled')
            {{-- for completed or cancelled reservations, just display table names from pivot --}}
            @foreach ($pivot_tables as $pivot)
                <div class="flex items-center space-x-2 p-2 border rounded-md bg-gray-50">
                    <iconify-icon icon="mdi:table-chair" class="text-xl text-gray-500"></iconify-icon>
                    <span>{{ $pivot->table_name }}</span>
                </div>
            @endforeach
        @else
            {{-- for active reservations, display checkboxes as usual --}}
            @foreach ($tables as $table)
                <label class="flex items-center space-x-2">
                    <input type="checkbox" wire:model="selected_tables" value="{{ $table->id }}">
                    <span>{{ $table->name }} (Kapasitas: {{ $table->capacity }})</span>
                </label>
            @endforeach

            {{-- show tables that have been deleted from master but still exist in pivot --}}
            @foreach ($pivot_tables as $pivot)
                @php
                    $exists = $tables->contains('id', $pivot->dining_table_id);
                @endphp
                @if (!$exists)
                    <label class="flex items-center space-x-2 text-red-500 opacity-70">
                        <input type="checkbox" disabled checked>
                        <span>{{ $pivot->table_name }} <small>(sudah dihapus)</small></span>
                    </label>
                @endif
            @endforeach
        @endif
    </div>
    @if(!($status === 'completed' || $status === 'cancelled'))
        @error('selected_tables')
            <div class="text-red-500 text-xs">{{ $message }}</div>
        @enderror
    @endif
</div>
                    
                    <div class="col-span-12">
                        <label class="form-label">Status Reservasi</label>
                        <div class="icon-field">
                            <span class="icon">
                                <iconify-icon icon="mdi:check-circle-outline"></iconify-icon>
                            </span>
                            <select wire:model="status" name="status" class="form-control" @if($status === 'completed') disabled @endif>
                                @if($status !== 'occupied' && $status !== 'completed')
                                    <option class="dark:bg-neutral-700" value="reserved" @if($status=='reserved') selected @endif>Reserved</option>
                                @endif
                                <option class="dark:bg-neutral-700" value="occupied" @if($status=='occupied') selected @endif>Occupied</option>
                                @if($status !== 'occupied' && $status !== 'completed')
                                    <option class="dark:bg-neutral-700" value="cancelled" @if($status=='cancelled') selected @endif>Cancelled</option>
                                @endif
                                <option class="dark:bg-neutral-700" value="completed" @if($status=='completed') selected @endif>Completed</option>
                            </select>
                        </div>
                        @error('status')
                            <div class="text-red-500 text-xs">{{ $message }}</div>
                        @enderror
                    </div>

                    @if ($status !== 'completed' && $status !== 'cancelled')
                        <div class="col-span-12">
                            <button type="submit" class="btn btn-primary-600">Update Reservasi</button>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
