<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pengeluaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
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
            padding: 6px;
            text-align: left;
            font-size: 11px;
        }
        th {
            background-color: #f2f2f2;
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
        <h2>Laporan Pengeluaran</h2>
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
                <th>Kategori</th>
                <th>Jumlah</th>
                <th>Deskripsi</th>
                <th>Dibuat Oleh</th>
                <th>Status</th>
                <th>Disetujui Oleh</th>
            </tr>
        </thead>
        <tbody>
            @foreach($expenses as $expense)
                <tr>
                    <td>{{ $expense->id }}</td>
                    <td>{{ $expense->date }}</td>
                    <td>{{ $expense->expenseCategory->name }}</td>
                    <td>{{ number_format($expense->amount) }}</td>
                    <td>{{ $expense->description }}</td>
                    <td>{{ $expense->user->name }}</td>
                    <td>
                        @if($expense->status == 'approved')
                            Disetujui
                        @elseif($expense->status == 'rejected')
                            Ditolak
                        @else
                            Pending
                        @endif
                    </td>
                    <td>{{ $expense->approver->name ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p>Point of Sales - Mini Cafe/Restaurant System &copy; {{ now()->year }}</p>
    </div>
</body>
</html>