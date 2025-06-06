<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Produk Terjual</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
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
            padding: 5px;
            text-align: left;
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
        <h2>Laporan Produk Terjual</h2>
        <p>Periode: {{ \Carbon\Carbon::parse($from)->format('d M Y') }} - {{ \Carbon\Carbon::parse($to)->format('d M Y') }}</p>
    </div>
    
    <div class="info">
        <p><strong>Tanggal Cetak:</strong> {{ now()->format('d M Y H:i') }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>SKU</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Diskon</th>
                <th>Subtotal</th>
                <th>Tanggal Transaksi</th>
                <th>Kasir</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productSales as $detail)
                <tr>
                    <td>{{ $detail->product ? $detail->product->name : $detail->product_name }}</td>
                    <td>{{ $detail->product ? $detail->product->sku : '-' }}</td>
                    <td>{{ $detail->quantity }}</td>
                    <td>{{ number_format($detail->price) }}</td>
                    <td>{{ $detail->product && $detail->product->is_discount ? $detail->product->discount : '-' }}</td>
                    <td>{{ number_format($detail->total) }}</td>
                    <td>{{ $detail->transaction ? $detail->transaction->created_at->format('Y-m-d H:i') : '-' }}</td>
                    <td>{{ $detail->transaction && $detail->transaction->user ? $detail->transaction->user->name : '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p>Point of Sales - Mini Cafe/Restaurant System &copy; {{ now()->year }}</p>
    </div>
</body>
</html>