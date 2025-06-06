<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 4px;
            text-align: left;
            font-size: 9px;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 10px;
        }
        .info {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Penjualan</h2>
        <p>Periode: {{ \Carbon\Carbon::parse($from)->format('d M Y') }} - {{ \Carbon\Carbon::parse($to)->format('d M Y') }}</p>
    </div>
    
    <div class="info">
        <p><strong>Tanggal Cetak:</strong> {{ now()->format('d M Y H:i') }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Kasir</th>
                <th>Member</th>
                <th>Metode Pembayaran</th>
                <th>Produk</th>
                <th>SKU</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Diskon</th>
                <th>Subtotal</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $row)
                <tr>
                    <td>{{ $row->id }}</td>
                    <td>{{ $row->created_at->format('Y-m-d H:i') }}</td>
                    <td>{{ $row->user->name ?? '-' }}</td>
                    <td>{{ $row->member->name ?? '-' }}</td>
                    <td>{{ $row->paymentMethod->name ?? '-' }}</td>
                    <td>
                        @foreach($row->transactionDetails as $detail)
                            {{ $detail->product->name ?? '-' }}@if(!$loop->last),@endif
                        @endforeach
                    </td>
                    <td>
                        @foreach($row->transactionDetails as $detail)
                            {{ $detail->product->sku ?? '-' }}@if(!$loop->last),@endif
                        @endforeach
                    </td>
                    <td>
                        @foreach($row->transactionDetails as $detail)
                            {{ $detail->quantity }}@if(!$loop->last),@endif
                        @endforeach
                    </td>
                    <td>
                        @foreach($row->transactionDetails as $detail)
                            {{ number_format($detail->price) }}@if(!$loop->last),@endif
                        @endforeach
                    </td>
                    <td>
                        @foreach($row->transactionDetails as $detail)
                            {{ $detail->product && $detail->product->is_discount ? $detail->product->discount : '-' }}@if(!$loop->last),@endif
                        @endforeach
                    </td>
                    <td>
                        @foreach($row->transactionDetails as $detail)
                            {{ number_format($detail->total) }}@if(!$loop->last),@endif
                        @endforeach
                    </td>
                    <td>{{ number_format($row->total_amount) }}</td>
                    <td>
                        @if ($row->status == 'pending')
                            Pending
                        @elseif ($row->status == 'paid')
                            Paid
                        @elseif ($row->status == 'cancelled')
                            Cancelled
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p>Point of Sales - Mini Cafe/Restaurant System &copy; {{ now()->year }}</p>
    </div>
</body>
</html>