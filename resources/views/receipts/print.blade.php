<!DOCTYPE html>
<html>

<head>
    <title>Struk #{{ $transaction->id }}</title>
    <meta charset="utf-8">
    <style>
        body {
            display: flex;
            font-family: 'Courier New', monospace;
            width: 60mm;
            margin: 0 auto;
            font-size: 12px;
            padding: 0;
     
        }

        .receipt-container {
            padding: 10px 8px;
            border: 1px dashed;
            box-shadow: 0 2px 8px;
        }

        .text-center {
            text-align: center;
        }

        .font-bold {
            font-weight: bold;
        }

        .text-xl {
            font-size: 18px;
        }

        .mb-4 {
            margin-bottom: 16px;
        }

        .mt-4 {
            margin-top: 16px;
        }

        .receipt-item {
            margin-bottom: 6px;
        }

        .receipt-table {
            width: 100%;
            border-collapse: collapse;
        }

        .receipt-table td {
            padding: 2px 0;
        }

        .right {
            text-align: right;
        }

        .left {
            text-align: left;
        }

        .divider {
            border-top: 1px dashed ;
            margin: 8px 0;
        }

        .total-row td {
            font-weight: bold;
            font-size: 13px;
            padding-top: 6px;
            padding-bottom: 6px;
        }

        .footer-note {
            font-size: 11px;
        }

        @media print {
            @page {
                margin: 0;
            }

            body {
                margin: 0;
            }

            .no-print {
                display: none;
            }

            .receipt-container {
                box-shadow: none;
                border: none;
            }
        }
    </style>
</head>

<body>
    <div class="receipt-container">
        <div class="text-center mb-4">
            <div class="font-bold text-xl">{{ config('app.name') }}</div>
            <div>{{ $transaction->created_at->format('d/m/Y H:i') }}</div>
            <div class="divider"></div>
        </div>
        <div>
            <table class="receipt-table mb-4">
                <tr>
                    <td class="left" width="45%">No. Struk</td>
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
                            <td class="left" width="55%">{{ $detail->product->name }}</td>
                            <td class="right" colspan="3" style="width: 45%;">
                                {{ $detail->quantity }} x<br>
                                @Rp{{ number_format($detail->price) }}<br>
                                = Rp{{ number_format($detail->quantity * $detail->price) }}
                            </td>
                        </tr>
                    </table>
                </div>
            @endforeach
            <div class="divider"></div>
            <table class="receipt-table mb-4">
                <tr>
                    <td class="left" colspan="3">Subtotal</td>
                    <td class="right">
                        Rp{{ number_format($transaction->total_amount + ($transaction->discount_amount ?? 0)) }}</td>
                </tr>
                @if ($transaction->member && ($transaction->discount_amount ?? 0) > 0)
                    <tr>
                        <td class="left" colspan="3">Diskon Member ({{ $transaction->member->name }})</td>
                        <td class="right">- Rp{{ number_format($transaction->discount_amount) }}</td>
                    </tr>
                @endif
                <tr class="total-row">
                    <td class="left" colspan="3">Total</td>
                    <td class="right">Rp{{ number_format($transaction->total_amount) }}</td>
                </tr>
                <tr>
                    <td class="left" colspan="3">Dibayar</td>
                    <td class="right">Rp{{ number_format($transaction->paid_amount) }}</td>
                </tr>
                <tr>
                  <td class="left" colspan="3">Kembalian</td>
                  <td class="right">
                    Rp{{ number_format(max(0, $transaction->paid_amount - $transaction->total_amount)) }}
                  </td>
                </tr>
            </table>
        </div>
        <div class="divider"></div>
        <div class="text-center mt-4 footer-note">
            <div>Terima kasih atas kunjungan Anda</div>
            <div>Barang yang sudah dibeli tidak dapat dikembalikan</div>
        </div>
        <div class="text-center mt-4 no-print">
            <button onclick="window.print()">Cetak Sekarang</button>
            <button onclick="window.close()">Tutup</button>
        </div>

        <script>
            window.onload = function() {
                window.print();
            }

            window.onafterprint = function() {
                window.close();
            };
        </script>
</body>

</html>
