<div class="md:col-span-6 col-span-12">


    <!-- Filter Kategori -->
    <div class="mb-4 sticky top-0">
        <div class="flex overflow-x-auto whitespace-nowrap space-x-2 scrollbar-hide"
            style="-ms-overflow-style: none; scrollbar-width: none;" onmousedown="this.isDown=true"
            onmouseup="this.isDown=false" onmouseleave="this.isDown=false"
            onmousemove="if(this.isDown){this.scrollLeft-=event.movementX}"
            onwheel="this.scrollLeft += (event.deltaY !== 0 ? event.deltaY : event.deltaX); event.preventDefault();">
            <style>
                .scrollbar-hide::-webkit-scrollbar {
                    display: none;
                }
            </style>
            <button wire:click="filterByCategory(null)"
                class="btn duration-300 rounded-full {{ $selectedCategory === null ? 'bg-primary-600 hover:bg-primary-700 text-white px-5 py-[11px]' : 'bg-white hover:bg-neutral-200 dark:bg-neutral-600 dark:hover:bg-neutral-500 text-dark px-5 py-[11px]' }}">
                All
            </button>
            @foreach ($categories as $category)
                <button wire:click="filterByCategory({{ $category->id }})"
                    class="btn duration-300 rounded-full {{ $selectedCategory === $category->id ? 'bg-primary-600 hover:bg-primary-700 text-white  px-5 py-[11px]' : 'bg-white hover:bg-neutral-200  dark:bg-neutral-600 dark:hover:bg-neutral-500 text-dark  px-5 py-[11px] ' }}">
                    {{ $category->name }} 
                </button>
            @endforeach
        </div>
    </div>

    <div>
        <div class="mb-4">
            <input type="text" wire:model.lazy="barcode" wire:keydown.enter="scanBarcode"
                placeholder="Pindahkan cursor ke input ini dan klik, lalu Scan atau ketik barcode di sini"
                class=" px-3 py-2 w-full form-control" autofocus>
            <button type="button" wire:click="scanBarcode"
                class="mt-2 bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg">
                Konfirmasi Barcode
            </button>
            <button type="button" class="mt-2 bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg"
                onclick="openCameraScanner()">
                Scan Barcode via Kamera
            </button>
            <div id="camera-modal" class=""
                style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100vw; height:100vh; background:rgba(0,0,0,0.7);">
                <div
                    style="margin:5vh auto; background:#fff; padding:20px; border-radius:8px; width:720px; position:relative;">
                    <div id="reader" style="width:640px"></div>
                    <button onclick="closeCameraScanner()" style="position:absolute;top:10px;right:10px;">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <div class="grid md:flex gap-5 md:justify-center">

        {{-- product item --}}
        <div class="w-full max-w-md">
            @if ($message)
                <div class="alert {{ $isWarning ? 'alert-warning bg-warning-600 border-warning-6000' : 'alert-success bg-success-600 border-success-600' }} text-white  px-6 py-[11px] mb-3 font-semibold text-lg rounded-xl flex items-center justify-between"
                    role="alert">
                    {{ $message }}
                    <button class="remove-button text-white text-2xl line-height-1" wire:click="$set('message', null)">
                        <iconify-icon icon="iconamoon:sign-times-light" class="icon"></iconify-icon>
                    </button>
                </div>
            @endif
            <div class="grid sm:grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 3xl:grid-cols-4 gap-4 overflow-y-auto"
                style="max-height: 70vh;">
                @if (count($products) > 0)
                    @foreach ($products as $product)
                        @if ($product->is_active == true)
                            <div
                                class="hover-scale-img border border-neutral-200 dark:border-neutral-600 rounded-2xl overflow-hidden ">
                                <div class="max-h-[266px] overflow-hidden">
                                    <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('assets/images/product/no-image.png') }}"
                                        alt="{{ $product->name }}"
                                        class=" hover-scale-img__img w-full h-[200px] object-cover">
                                </div>
                                <div class="py-4 px-5 bg-white   dark:bg-neutral-700 h-full">
                                    <h6 class="mb-1.5 truncate w-full" title="{{ $product->name }}">
                                        {{ $product->name }}
                                    </h6>
                                    @if ($product->is_discount)
                                        @php
                                            $discountedPrice =
                                                $product->discount_type === 'percent'
                                                    ? $product->price - ($product->price * $product->discount) / 100
                                                    : $product->price - $product->discount;
                                        @endphp
                                        <p class="mb-0 text-lg text-secondary-light">
                                        <div class="md:text-3xl">
                                            <span class="line-through ">Rp.
                                                {{ number_format($product->price, 0, ',', '.') }}</span>
                                            <span class="ml-2 font-bold">Rp.
                                                {{ number_format($discountedPrice, 0, ',', '.') }}</span>
                                        </div>

                                        </p>
                                        <span class="ml-2 text-xs text-primary-600">
                                            (Diskon
                                            @if ($product->discount_type === 'percent')
                                                {{ $product->discount }}%
                                            @else
                                                Rp. {{ number_format($product->discount, 0, ',', '.') }}
                                            @endif)
                                        </span>
                                    @else
                                        <span class="ml-2 text-xs text-neutral-600">
                                            Tidak ada Diskon
                                        </span>
                                        <p class="mb-0 text-lg text-secondary-light">
                                            Rp. {{ number_format($product->price, 0, ',', '.') }}
                                        </p>
                                    @endif
                                    <p
                                        class="mb-0 text-lg text-secondary-light {{ $product->stock <= 5 ? 'text-danger-600' : '' }}">
                                        Stock: {{ $product->stock }}
                                        @if ($product->stock <= 5 && $product->stock > 0)
                                            <span class="text-red-500 font-semibold ml-2">(hampir habis)</span>
                                        @endif
                                    </p>
                                    <button wire:click="addToCart({{ $product->id }})"
                                        class="bg-primary-600 hover:bg-primary-700 text-white px-5 py-[11px] rounded-xl btn mt-2">Add
                                        to
                                        Cart</button>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @else
                    <div>No Product Available</div>
                @endif
            </div>
        </div>
        {{-- cart --}}
        <div class="flex-1 ">
            <div class="overflow-y-auto bg-white dark:bg-neutral-700 rounded-md" style="max-height: none;">
                <table class="table">
                    <thead class="bg-white dark:bg-neutral-700">
                        <tr class="">
                            <th>Image</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- cart item --}}
                        @foreach ($cart as $item)
                            <tr wire:key="cart-item-{{ $item['id'] }}">
                                <td>
                                    <img src="{{ asset('storage/' . $item['image']) }}" alt=""
                                        class="shrink-0 me-3 rounded-lg w-10 h-10 object-cover">
                                </td>
                                <td>{{ $item['name'] }}</td>
                                <td>Rp. {{ number_format($item['price'], 0, ',', '.') }}</td>
                                <td>
                                    <button wire:click="decrementQuantity({{ $item['id'] }})"
                                        class="px-2">-</button>
                                    {{ $item['quantity'] }}
                                    <button wire:click="incrementQuantity({{ $item['id'] }})"
                                        class="px-2">+</button>
                                </td>
                                <td>
                                    <button wire:click="removeFromCart({{ $item['id'] }})"
                                        class="text-red-500 px-2">Hapus</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4 p-4 bg-white dark:bg-neutral-700 rounded-lg">

                    {{-- member --}}
                    {{-- <div class="mb-4">
                        <label for="member_id" class="block text-sm font-medium mb-1">Pilih Member</label>
                        <input id="member_id" wire:model="member_id" wire:change="$refresh"
                            class="w-full border rounded px-2 py-2">
                    </div> --}}

                    {{-- <div class="mb-4">
                        <label for="member_id" class="block text-sm font-medium mb-1 ">Pilih Member</label>
                        <select id="member_id" wire:model="member_id" wire:change="$refresh"
                            class="w-full border rounded px-2 py-2 form-control">
                            <option value="" class="dark:bg-neutral-600 ">Customer</option>
                            @foreach ($members as $member)
                                <option class="dark:bg-neutral-600 " value="{{ $member->id }}">{{ $member->name }}
                                </option>
                            @endforeach
                        </select>
                    </div> --}}

                    <div class="mb-4">
                        <label for="member_id" class="block text-sm font-medium mb-1">Masukkan ID Member</label>
                        <div class="flex gap-2">
                            <input id="member_id" type="text" wire:model.lazy="member_id_input"
                                class="w-full border rounded px-2 py-2 form-control"
                                placeholder="Masukkan ID Member (misal: 12345)">
                            <button type="button" wire:click="checkMember"
                                class="ml-2 text-sm bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg">
                                Check
                            </button>
                        </div>

                    </div>

                    @if ($member)
                        <div class="mb-2 p-2 rounded bg-green-50 text-green-700">
                            Member ditemukan: <b>{{ $member->name }}</b> (ID: {{ $member->id }})
                        </div>
                    @elseif (!empty($member_id_input))
                        <div class="mb-2 p-2 rounded bg-red-50 text-red-700">
                            Member dengan ID <b>{{ $member_id_input }}</b> tidak ditemukan.
                        </div>
                    @endif

                    @if ($member_id)
                        <div class="text-green-600 mb-2">Diskon Member 5% telah diterapkan!</div>
                    @endif


                    {{-- payment method --}}
                    <div class="mb-4">
                        <label for="payment_method_id" class="block text-sm font-medium mb-1">Metode Pembayaran</label>
                        <select id="payment_method_id" wire:model="payment_method_id"
                            class="w-full border rounded px-2 py-1 form-control">
                            <option class="dark:bg-neutral-600 ">-- Pilih Metode Pembayaran --</option>
                            @foreach ($paymentMethods as $method)
                                @if ($method->is_active == 1)
                                    <option class="dark:bg-neutral-600 " value="{{ $method->id }}">
                                        {{ $method->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="flex justify-between mb-2">
                        <span>Subtotal</span>
                        {{-- computed properties --}}
                        <span>Rp. {{ number_format($this->subtotal, 0, ',', '.') }}</span>
                    </div>

                    @if (collect($cart)->where('is_discount', true)->count() > 0)
                        <div class="mb-2">
                            <span class="font-semibold text-sm text-primary-700">Detail Produk Diskon:</span>
                            <ul class="text-xs mt-1">
                                @foreach ($cart as $item)
                                    @if (!empty($item['is_discount']))
                                        @php
                                            $hargaDiskon =
                                                $item['discount_type'] === 'percent'
                                                    ? $item['price'] - ($item['price'] * $item['discount']) / 100
                                                    : $item['price'] - $item['discount'];
                                        @endphp
                                        <li class="flex justify-between">
                                            <span>
                                                {{ $item['name'] }}
                                                ({{ $item['quantity'] }}x)
                                                <span
                                                    class="text-red-400 line-through ml-1">Rp.{{ number_format($item['price'], 0, ',', '.') }}</span>
                                            </span>
                                            <span class="text-green-600 font-bold">
                                                Rp.{{ number_format($hargaDiskon * $item['quantity'], 0, ',', '.') }}
                                            </span>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="flex justify-between font-bold text-lg">
                        <span>Total</span>
                        {{-- computed properties --}}
                        <span>Rp. {{ number_format($this->total, 0, ',', '.') }}</span>
                    </div>
                    <button class="mt-4 w-full bg-primary-600 hover:bg-primary-700 text-white py-2 rounded"
                        wire:click="saveTransaction" @if ($this->total == 0) disabled @endif>
                        Charge Rp. {{ number_format($this->total, 0, ',', '.') }}
                    </button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        let html5QrCode;

        function openCameraScanner() {
            document.getElementById("camera-modal").style.display = "block";
            html5QrCode = new Html5Qrcode("reader");
            const config = {
                fps: 10,
                qrbox: {
                    width: 350,
                    height: 120
                },
                formatsToSupport: [
                    Html5QrcodeSupportedFormats.QR_CODE,
                    Html5QrcodeSupportedFormats.CODE_128,
                    Html5QrcodeSupportedFormats.EAN_13,
                    Html5QrcodeSupportedFormats.EAN_8,
                    Html5QrcodeSupportedFormats.UPC_A,
                    Html5QrcodeSupportedFormats.UPC_E,
                    Html5QrcodeSupportedFormats.CODE_39,
                    Html5QrcodeSupportedFormats.CODE_93,
                    Html5QrcodeSupportedFormats.ITF,
                ]
            };
            html5QrCode.start({
                    facingMode: "environment"
                },
                config,
                (decodedText, decodedResult) => {
                    document.querySelector(`input[wire\\:model\\.lazy="barcode"]`).value = decodedText;
                    @this.set("barcode", decodedText);
                    @this.scanBarcode();
                    closeCameraScanner();
                },
                (errorMessage) => {
                    /* ignore errors */
                }
            );
        }

        function closeCameraScanner() {
            document.getElementById("camera-modal").style.display = "none";
            if (html5QrCode) html5QrCode.stop().then(() => html5QrCode.clear());
        }
    </script>

</div>
