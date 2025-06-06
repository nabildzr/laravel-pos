<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ringkasan Transaksi</title>
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
        <h2>Ringkasan Transaksi</h2>
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
                <th>Total Belanja</th>
                <th>Jumlah Dibayar</th>
                <th>Kembalian</th>
                <th>Status</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->id }}</td>
                    <td>{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
                    <td>{{ $transaction->user->name ?? '-' }}</td>
                    <td>{{ $transaction->member->name ?? '-' }}</td>
                    <td>{{ $transaction->paymentMethod->name ?? '-' }}</td>
                    <td>{{ number_format($transaction->total_amount) }}</td>
                    <td>{{ number_format($transaction->paid_amount) }}</td>
                    <td>{{ number_format($transaction->return_amount) }}</td>
                    <td>
                        @if ($transaction->status == 'pending')
                            Pending
                        @elseif ($transaction->status == 'paid')
                            Paid
                        @elseif ($transaction->status == 'cancelled')
                            Cancelled
                        @endif
                    </td>
                    <td>{{ $transaction->note ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p>Point of Sales - Mini Cafe/Restaurant System &copy; {{ now()->year }}</p>
    </div>
</body>
</html>