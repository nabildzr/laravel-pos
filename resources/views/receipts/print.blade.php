<!DOCTYPE html>
<html>

<head>
    <title>Struk #{{ $transaction->id }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @page {
            size: 58mm auto;
            /* Standardized receipt width */
            margin: 0;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f5f5f5;
            font-family: 'Courier New', monospace;
        }

        .outer-container {
            width: 100%;
            display: flex;
            justify-content: center;
            padding: 20px;
        }

        .receipt-container {
            width: 56mm;
            /* Receipt width */
            padding: 5px 2px;
            border: 1px dashed #999;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            background-color: white;
            font-size: 10px;
        }

        .text-center {
            text-align: center;
        }

        .font-bold {
            font-weight: bold;
        }

        .text-xl {
            font-size: 14px;
        }

        .mb-4 {
            margin-bottom: 12px;
        }

        .mt-4 {
            margin-top: 12px;
        }

        .receipt-item {
            margin-bottom: 4px;
        }

        .receipt-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            /* Fixed table layout to control column widths */
        }

        .receipt-table td {
            padding: 2px 0;
            word-break: break-word;
            /* Break long text */
        }

        .right {
            text-align: right;
        }

        .left {
            text-align: left;
        }

        .divider {
            border-top: 1px dashed #999;
            margin: 6px 0;
        }

        .total-row td {
            font-weight: bold;
            font-size: 11px;
            padding-top: 4px;
            padding-bottom: 4px;
        }

        .footer-note {
            font-size: 9px;
        }

        .no-print button {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin: 0 5px;
            font-size: 12px;
        }

        .no-print button:hover {
            background-color: #45a049;
        }

        @media print {
            @page {
                margin: 0;
            }

            html,
            body {
                background-color: white;
                display: block;
                height: auto;
            }

            .outer-container {
                padding: 0;
                width: auto;
            }

            .no-print {
                display: none;
            }

            .receipt-container {
                box-shadow: none;
                border: none;
                padding: 0;
                width: 56mm;
                margin: 0;
            }
        }
    </style>
</head>

<body>
    <div class="outer-container">
        <div class="receipt-container">
            @if ($business && $business->logo)
                <div class="mb-2" style="display: flex; justify-content: center; align-items: center;">
                    <img src="{{ asset('storage/' . $business->logo) }}" alt="{{ $business->name }}"
                        style="max-width: 100%; height: 40px; margin: 0 auto; margin-bottom: 10px; margin-top:20px;">
                </div>
            @endif

            <div class="text-center mb-4">
                <div class="font-bold text-xl">
                    @php $business = \App\Models\BusinessSetting::first(); @endphp
                    @if ($business->name)
                        {{ $business->name }}
                    @else
                        Mini Cafe/Restaurant
                    @endif
                </div>
                @if ($business && ($business->phone || $business->email))
                    <div class="text-xs">
                        @if ($business->phone)
                            Tel: {{ $business->phone }}
                        @endif
                        @if ($business->email && $business->phone)
                            |
                        @endif
                        @if ($business->email)
                            {{ $business->email }}
                        @endif
                    </div>
                @endif

                @if ($business && $business->tax_number)
                    <div class="text-xs">NPWP: {{ $business->tax_number }}</div>
                @endif
                <div>{{ $transaction->created_at->format('d/m/Y H:i') }}</div>
                <div class="divider"></div>
            </div>
            <div>
                <table class="receipt-table mb-4">
                    <tr>
                        <td class="left" width="40%">No. Struk</td>
                        <td class="right">#{{ $transaction->id }}</td>
                    </tr>
                    <tr>
                        <td class="left">Kasir</td>
                        <td class="right">{{ $transaction->user->name ?? 'Sistem' }}</td>
                    </tr>
                    @if ($transaction->member)
                        <tr>
                            <td class="left">Pelanggan</td>
                            <td class="right">{{ $transaction->member->name }}</td>
                        </tr>
                    @endif
                </table>
                <div class="divider"></div>
                @foreach ($transaction->transactionDetails as $detail)
                    <div class="receipt-item">
                        <table class="receipt-table">
                            <tr>
                                <td class="left" style="width: 50%;">{{ $detail->product->name ?? 'Unknown' }}</td>
                                <td class="right" colspan="3" style="width: 50%;">
                                    {{ $detail->quantity }} x
                                    @Rp{{ number_format($detail->price) }}
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td class="right" colspan="3">=
                                    Rp{{ number_format($detail->quantity * $detail->price) }}</td>
                            </tr>
                        </table>
                    </div>
                @endforeach
                <div class="divider"></div>
                <table class="receipt-table mb-4">
                    <tr>
                        <td class="left" width="55%">Subtotal</td>
                        <td class="right">
                            Rp{{ number_format($transaction->total_amount + ($transaction->discount_amount ?? 0)) }}
                        </td>
                    </tr>
                    @if ($transaction->member && ($transaction->discount_amount ?? 0) > 0)
                        <tr>
                            <td class="left">Diskon Member</td>
                            <td class="right">- Rp{{ number_format($transaction->discount_amount) }}</td>
                        </tr>
                    @endif
                    <tr class="total-row">
                        <td class="left">Total</td>
                        <td class="right">Rp{{ number_format($transaction->total_amount) }}</td>
                    </tr>
                    <tr>
                        <td class="left">Dibayar</td>
                        <td class="right">Rp{{ number_format($transaction->paid_amount) }}</td>
                    </tr>
                    <tr>
                        <td class="left">Kembalian</td>
                        <td class="right">
                            Rp{{ number_format(max(0, $transaction->paid_amount - $transaction->total_amount)) }}
                        </td>
                    </tr>
                </table>
            </div>
            <div class="divider"></div>
            <div class="text-center mt-4 footer-note">
                @if ($business && $business->receipt_footer)
                    <div>{{ $business->receipt_footer }}</div>
                @else
                    <div>Terima kasih atas kunjungan Anda</div>
                @endif
                <div>Barang yang sudah dibeli tidak dapat dikembalikan</div>
                @if ($business && $business->website)
                    <div>{{ $business->website }}</div>
                @endif
            </div>
            <div class="text-center mt-4 no-print ">
                <button onclick="window.print()">Cetak Sekarang</button>
                <button onclick="window.close()">Tutup</button>
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            // Slight delay to ensure proper rendering before print
            setTimeout(function() {
                window.print();
            }, 500);
        }

        window.onafterprint = function() {
            // Optional: close window after printing
            window.close();
        };
    </script>
</body>

</html>
