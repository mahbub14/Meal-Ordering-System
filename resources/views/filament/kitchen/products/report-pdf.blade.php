<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Products Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif; /* Good UTF-8 font for PDFs */
            font-size: 12px;
            margin: 20px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #333;
            padding: 8px 12px;
            text-align: left;
        }
        th {
            background-color: #eee;
        }
        h2, h4 {
            margin: 0;
        }
        .date-range {
            margin-top: 10px;
            font-style: italic;
            color: #555;
        }
        .total-price {
            margin-top: 15px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>Products Report</h2>
    @if($fromDate || $toDate)
        <div class="date-range">
            Date Range: 
            {{ $fromDate ?? 'Start' }} - {{ $toDate ?? 'End' }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Unit</th>
                <th>Unit Price (BDT)</th>
                <th>Total Price (BDT)</th>
                <th>Purchased Date</th>
            </tr>
        </thead>
        <tbody>
            @php $totalPriceSum = 0; @endphp
            @foreach($products as $product)
                <tr>
                    <td>{{ $product['name'] }}</td>
                    <td>{{ $product['qnt'] }}</td>
                    <td>{{ $product['unit'] }}</td>
                    <td>{{ number_format($product['unit_price'], 2) }}</td>
                    <td>{{ number_format($product['price'], 2) }}</td>
                    <td>{{ $product['created_at'] }}</td>
                </tr>
                @php $totalPriceSum += $product['price']; @endphp
            @endforeach
        </tbody>
    </table>

    <div class="total-price">
        Total Price: {{ number_format($totalPriceSum, 2) }} BDT
    </div>
</body>
</html>
