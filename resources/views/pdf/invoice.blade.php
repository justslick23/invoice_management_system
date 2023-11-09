<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="{{ public_path('fonts/KumbhSans-Regular.ttf') }}" rel="stylesheet">

    <style>
  

        * {
            font-family: 'Kumbh Sans', sans-serif !important;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Kumbh Sans', sans-serif !important;

            color: #333;
        }

        .container {
            padding: 20px;
        }

        .logo img {
            max-width: 100%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .invoice-table {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .invoice-table th, .invoice-table td {
            padding: 15px;
            text-align: left;
        }

        .invoice-table th {
            background-color: #4CAF50;
            color: white;
        }

        .invoice-table tbody td {
            background-color: white;
        }

        .invoice-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
    <title>Invoice</title>
</head>
<body>
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th colspan="2">
                        <div class="logo">
                            <img src="{{ public_path('black/img/slicktech.png') }}" width="250" alt="Logo">
                        </div>
                    </th>
                    <th colspan="2">
                        <h1 style="font-size: 2.3em; text-align: right;"><strong>INVOICE</strong></h1>
                        <h4 style="text-align: right;">{{ $invoice->created_at->format('d F Y') }}</h4>
                    </th>
                </tr>
            </thead>
            <br>
            <br>
            <tbody>
                <tr>
                    <td colspan="2">
                        <span><strong>Office Address</strong></span>
                        <p>Ha Matala Phase 2</p>
                        <p>Maseru, Lesotho</p>  
                        <p>(+266) 6823 1628</p>  
                    </td>
                    <td colspan="2" >
                        <span><strong>Bill To:</strong></span>
                        <p>{{$invoice->customer->name}}</p>
                        <p>{{$invoice->customer->contact_person}}</p>
                        <p>{{$invoice->customer->address}}</p>
                    </td>
                </tr>
            </tbody>
        </table>

        <br><br>
        <table class="invoice-table">
            <thead>
                <tr>
                    <th>Items Description</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->items as $item)
                    @php 
                        $subtotalProducts = $item->quantity * $item->product->price;
                    @endphp
                    <tr>
                        <td>{{$item->product->name}}</td> 
                        <td>{{$item->product->price}}</td> 
                        <td>{{$item->quantity}}</td> 
                        <td>M{{number_format($subtotalProducts, 2)}}</td> 
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
