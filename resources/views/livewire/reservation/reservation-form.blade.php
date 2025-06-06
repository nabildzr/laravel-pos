<div class="md:col-span-6 col-span-12">
    <div class="card border-0">
        <div class="card-header">
            <h5 class="text-lg font-semibold mb-0">Create Reservation</h5>
        </div>

        <div class="card-body">
            @include('layout.feedback')

            @if (session()->has('success'))
                <div class="alert alert-success mb-3">{{ session('success') }}</div>
            @endif

            <form wire:submit.prevent='save'>


                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-12">
                        <label class="form-label">Nama Pereservasi</label>
                        <div class="icon-field">
                            <span class="icon">
                                <iconify-icon icon="mdi:account"></iconify-icon>
                            </span>
                            <input type="text" wire:model.change='contact_name' name="contact_name"
                                class="form-control" value="{{ old('contact_name') }}" placeholder="Masukkan nama">
                        </div>
                        @error('contact_name')
                            <div class="text-red-500 text-xs">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-span-12">
                        <label class="form-label">No. Telepon</label>
                        <div class="icon-field">
                            <span class="icon">
                                <iconify-icon icon="mdi:phone"></iconify-icon>
                            </span>
                            <input type="text" wire:model.change='contact_phone' name="contact_phone"
                                class="form-control" value="{{ old('contact_phone') }}"
                                placeholder="Masukkan nomor telepon">
                        </div>
                        @error('contact_phone')
                            <div class="text-red-500 text-xs">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-span-12">
                        <label class="form-label">Email</label>
                        <div class="icon-field">
                            <span class="icon">
                                <iconify-icon icon="mdi:email"></iconify-icon>
                            </span>
                            <input type="text" wire:model.change='contact_email' name="email" class="form-control"
                                value="{{ old('contact_email') }}" placeholder="Masukkan email (opsional)">
                        </div>
                        @error('contact_email')
                            <div class="text-red-500 text-xs">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-span-12">
                      <label class="form-label">Address</label>
                      <div class="icon-field">
                        <span class="icon">
                          <iconify-icon icon="mdi:address-marker"></iconify-icon>
                        </span>
                        <input type="text" wire:model.change='contact_address' name="contact_address" class="form-control"
                          value="{{ old('contact_address') }}" placeholder="Masukkan address (opsional)">
                      </div>
                      @error('contact_address')
                        <div class="text-red-500 text-xs">{{ $message }}</div>
                      @enderror
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <label class="form-label">Tanggal</label>
                        <div class="icon-field">
                            <span class="icon">
                                <iconify-icon icon="mdi:calendar"></iconify-icon>
                            </span>
                            <input type="date" wire:model.change='reservation_date' name="reservation_date"
                                class="form-control" value="{{ old('reservation_date') }}">
                        </div>
                        @error('reservation_date')
                            <div class="text-red-500 text-xs">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <label class="form-label">Waktu</label>
                        <div class="icon-field">
                            <span class="icon">
                                <iconify-icon icon="mdi:clock-outline"></iconify-icon>
                            </span>
                            <input type="time" wire:model.change='reservation_time' name="reservation_time"
                                class="form-control" value="{{ old('reservation_time') }}">
                        </div>
                        @error('reservation_time')
                            <div class="text-red-500 text-xs">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-span-12">
                        <label class="form-label">Jumlah Tamu</label>
                        <div class="icon-field">
                            <span class="icon">
                                <iconify-icon icon="mdi:account-group-outline"></iconify-icon>
                            </span>
                            <input type="number" wire:model.change='guest_count' name="guest_count" min="1"
                                class="form-control" value="{{ old('guest_count') }}"
                                placeholder="Masukkan jumlah tamu">
                        </div>
                        @error('guest_count')
                            <div class="text-red-500 text-xs">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-span-12">
                        <label class="form-label">DP Awal (Down Payment)</label>
                        <div class="icon-field">
                            <span class="icon">
                                <iconify-icon icon="mdi:account-group-outline"></iconify-icon>
                            </span>
                            <input type="number" wire:model.change='down_payment_amount' name="down_payment_amount" min="1"
                                class="form-control" value="{{ old('down_payment_amount') }}"
                                placeholder="Masukkan Jumlah Down Payment">
                        </div>
                        @error('down_payment_amount')
                            <div class="text-red-500 text-xs">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-span-12">
                        <label class="form-label">Pilih Meja</label>
                        <div class="grid grid-cols-2 gap-2">
                            @foreach ($tables as $table)
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" wire:model="selected_tables" name="selected_tables[]"
                                        value="{{ $table->id }}"
                                        {{ in_array($table->id, old('selected_tables', [])) ? 'checked' : '' }}>
                                    <span>{{ $table->name }} (Kapasitas: {{ $table->capacity }})</span>
                                </label>
                            @endforeach

                            
                        </div>
                        @error('selected_tables')
                            <div class="text-red-500 text-xs">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-span-12">
                        <button type="submit" class="btn btn-primary-600">Reservasi</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
