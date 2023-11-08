<!DOCTYPE html>
<html>
<head>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Invoice</title>
    <style>
        body {
            font-family: 'Inter', sans-serif !important;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .invoice {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .invoice-header {
            text-align: center;
            background-color: #007bff;
            color: #fff;
            padding: 10px 0;
        }
        .invoice-header h1 {
            font-size: 24px;
        }
        .invoice-details {
            margin-top: 20px;
        }
        .invoice-details table {
            width: 100%;
            border-collapse: collapse;
        }
        .invoice-details th, .invoice-details td {
            border: 1px solid #ccc;
            padding: 8px;
        }
        .invoice-details th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: left;
        }
        .invoice-details td {
            text-align: right;
        }
        .customer-details {
            margin-top: 20px;
        }
        .customer-details h2 {
            font-size: 18px;
        }
        .customer-details p {
            margin: 5px 0;
        }
        .invoice-footer {
            margin-top: 20px;
            text-align: center;
        }
        .invoice-footer p {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="invoice">
        <div class="invoice-header">
            <h1>Invoice</h1>
        </div>
        <div class="customer-details">
            <h2>Customer Information:</h2>
            <p><strong>Customer Name:</strong> {{ $invoice->customer->name }}</p>
            <p><strong>Customer Email:</strong> {{ $invoice->customer->email }}</p>
            <p><strong>Customer Address:</strong> {{ $invoice->customer->address }}</p>
            <!-- Add more customer details as needed -->
        </div>
        <div class="invoice-details">
            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Loop through invoice items and populate the table -->
                    @foreach($invoice->items as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>M{{ number_format($item->product->price, 2) }}</td>
                        <td>M{{ number_format($item->quantity * $item->product->price, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="invoice-footer">
            <p>Total Amount: ${{ number_format($invoice->total, 2) }}</p>
        </div>
    </div>
</body>
</html>
