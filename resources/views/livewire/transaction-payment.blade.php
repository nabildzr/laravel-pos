<div class="grid grid-cols-1 md:grid-cols-2 md:flex justify-center mx-auto max-w-xl gap-2">
    {{-- left content --}}
    <div class="w-full flex flex-col justify-between p-6 bg-white dark:bg-neutral-900 rounded shadow"
        style="height: 82.5dvh;">
        <div>
            <div class="flex justify-between items-center pb-2">
                <p class="text-3xl  font-bold">Transaksi #{{ $transaction['id'] }}</p>
                @if ($transaction->status === 'paid')
                    <div>
                        <h2
                            class="bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400 px-6 md:px-14  py-2 md:py-4 rounded-full font-medium text-sm md:text-xl">
                            Paid</h2>
                    </div>
                @elseif ($transaction->status === 'pending')
                    <div>
                        <h2
                            class="bg-warning-100 dark:bg-warning-600/25 text-warning-600 dark:text-warning-400 px-6 md:px-14  py-2 md:py-4 rounded-full font-medium text-sm md:text-xl">
                            Pending</h2>
                    </div>
                @elseif ($transaction->status === 'cancelled')
                    <div>
                        <h2
                            class="bg-danger-100 dark:bg-danger-600/25 text-danger-600 dark:text-danger-400 px-14 py-4 rounded-full font-medium text-sm md:text-xl">
                            Cancelled</h2>
                    </div>
                @else
                    <div>
                        <h2 class="px-14 py-4 rounded-full font-medium text-xl">{{ ucfirst($transaction->status) }}</h2>
                    </div>
                @endif
            </div>

            {{-- Tabel Produk --}}
            <div class="w-full mb-3">

                @foreach ($transactionDetail as $detail)
                    @php
                        $loopIndex = $loop->index ?? 0;
                        $isOdd = $loopIndex % 2 === 1;
                    @endphp
                    <div
                        class="w-full flex flex-col justify-center px-4 py-2 rounded-xl {{ $isOdd ? 'bg-white dark:bg-neutral-900' : 'bg-neutral-100 dark:bg-neutral-800' }}">
                        <div class="flex items-center">
                            <span class="font-bold" style="padding-right: 10px">{{ $detail->quantity ?? 1 }}</span>
                            <span class="font-bold w-full truncate text-left">{{ $detail->product_name ?? '-' }}</span>
                            <span class="w-full text-end text-green-600 font-bold ml-2">Rp
                                {{ number_format($detail->price ?? 0, 0, ',', '.') }}</span>

                            </span>
                        </div>
                        @if (
                            $detail->product->is_discount &&
                                strval($detail->product->price) &&
                                ($detail->product->discount ?? 0) &&
                                $detail->product->discount ??
                                0 > 0)
                            <div class="flex justify-end gap-4 items-center text-gray-400 dark:text-neutral-600">
                                <span class="" style="font-size: 13px;">
                                    Discount
                                    @if ($detail->product->discount_type === 'percent')
                                        {{ $detail->product->discount }}%
                                    @endif

                                    @if ($detail->product->discount_type === 'amount')
                                        Rp {{ number_format($detail->product->discount, 0, ',', '.') }}
                                    @endif
                                </span>
                                <span style="font-size: 13px" class="line-through text-gray-400">
                                    Rp {{ number_format($detail->product->price, 0, ',', '.') }}
                                </span>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>



            {{-- Total --}}
            @php
                $subtotal = 0;
                foreach ($transactionDetail as $detail) {
                    $subtotal += ($detail->price ?? 0) * ($detail->quantity ?? 1);
                }
            @endphp

            <div class="flex justify-between mb-2">
                <span>Subtotal</span>
                <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
            </div>





            <div class="flex justify-between font-semibold text-lg mb-4 ">
                <span>Grand Total</span>
                <span>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
            </div>
        </div>

        <div>
            <div class="p-6 bg-neutral-100 dark:bg-neutral-800 gap-2 flex flex-col rounded-lg mb-4">
                <div class="flex justify-between">
                    <span class="font-semibold">Uang yang diberikan</span>
                    <span class="">Rp {{ number_format((float) $paid_amount, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-semibold">Kembalian</span>
                    <span class="">Rp {{ number_format((float) $change, 0, ',', '.') }}</span>
                </div>
            </div>
            @if (!$isInvoice || $transaction->status === 'pending')
                <button wire:click="save"
                    class="justify-center btn w-full  bg-success-600 text-white hover:bg-neutral-600">Selesaikan
                    Pembayaran</button>
            @endif
        </div>
    </div>

    {{-- right content --}}
    <div class="w-full p-6 bg-white dark:bg-neutral-900 rounded shadow">
        {{-- Form pembayaran --}}
        <div class="mb-4">
            <label>Status Pembayaran</label>
            @if ($isInvoice && $transaction->status !== 'pending')
                <select class="form-control" disabled>
                    <option class="dark:bg-neutral-600" value="pending"
                        @if ($status === 'pending') selected @endif>Pending</option>
                    <option class="dark:bg-neutral-600" value="paid"
                        @if ($status === 'paid') selected @endif>Paid</option>
                    <option class="dark:bg-neutral-600" value="cancelled"
                        @if ($status === 'cancelled') selected @endif>Cancelled</option>
                </select>
            @else
                <select wire:model="status" wire:change="statusChanged" class="form-control">
                    <option class="dark:bg-neutral-600" value="pending">Pending</option>
                    <option class="dark:bg-neutral-600" value="paid">Paid</option>
                    <option class="dark:bg-neutral-600" value="cancelled">Canceled</option>
                </select>
            @endif


        </div>





        @if ($status === 'paid')
            <div class="mb-4">
                <label>Uang dari Pembeli</label>

                {{-- input masukkan nominal  --}}
                <input type="number" name="paid_amount" wire:model.live.debounce.250ms="paid_amount"
                    wire:key="paid_amount_{{ $paid_amount }}" class="form-control" placeholder="Masukkan nominal">

                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 0.5rem; margin-top: 0.75rem;">
                    <!-- Number buttons -->
                    @foreach (range(1, 9) as $num)
                        <button type="button"
                            class="btn items-center justify-center bg-neutral-100 hover:bg-neutral-200 dark:bg-neutral-800  text-lg font-bold py-3"
                            wire:click="appendToAmount({{ $num }})">{{ $num }}</button>
                    @endforeach
                    <button type="button"
                        class="btn items-center justify-center bg-warning-100 hover:bg-warning-200 text-warning-600 text-lg font-bold py-3 "
                        wire:click="eraseAmount()">
                        <iconify-icon icon="mdi:erase" class="icon text-lg"></iconify-icon>
                    </button>
                    {{-- ...existing code... --}}
                    <button type="button"
                        class="btn items-center justify-center bg-neutral-100 hover:bg-neutral-200 dark:bg-neutral-800 text-lg font-bold py-3"
                        wire:click="appendToAmount(0)">0</button>
                    <button type="button"
                        class="btn items-center justify-center bg-neutral-100 hover:bg-neutral-200 dark:bg-neutral-800 text-lg font-bold py-3"
                        wire:click="appendToAmount('000')">000</button>
                    <button type="button"
                        class="btn items-center justify-center bg-danger-100 hover:bg-danger-200 text-danger-600 text-lg font-bold py-3"
                        wire:click="clearAmount()">C</button>
                </div>

                <div class="grid grid-cols-2 gap-2 mt-2">
                    <!-- Quick amount buttons -->
                    <button type="button"
                        class="btn items-center justify-center bg-primary-100 hover:bg-primary-200 text-primary-600"
                        wire:click="setQuickAmount({{ $transaction->total_amount }})">Uang Pas</button>
                    <button type="button"
                        class="btn items-center justify-center bg-primary-100 hover:bg-primary-200 text-primary-600"
                        wire:click="setQuickAmount(50000)">Rp 50.000</button>
                    <button type="button"
                        class="btn items-center justify-center bg-primary-100 hover:bg-primary-200 text-primary-600"
                        wire:click="setQuickAmount(100000)">Rp 100.000</button>
                    <button type="button"
                        class="btn items-center justify-center bg-primary-100 hover:bg-primary-200 text-primary-600"
                        wire:click="setQuickAmount(200000)">Rp 200.000</button>
                </div>





            </div>
        @elseif ($status === 'pending')
            <div class="mb-4 font-bold text-lg">Menunggu pembayaran / Bayar Nanti</div>
            <div class="mb-4">
                <label for="note" class="block mb-1">Catatan</wlabel>
                    <textarea id="note" wire:model="note" class="form-control w-full" rows="2"
                        placeholder="Tambahkan catatan..."></textarea>
            </div>
        @elseif ($status === 'cancelled')
            <div class="mb-4 text-red-600">Transaksi dibatalkan.</div>
        @endif

    </div>

</div>
