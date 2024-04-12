<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice V3</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link href="{{ public_path('style.css') }}" rel="stylesheet">
    <link href="{{ public_path('black/css/black-dashboard.css') }}" rel="stylesheet">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Custom Styles for A4 Size -->
    <style>
        @page {
            size: A4;
            margin: 0;
            padding: 0;
        }

        body {
            padding: 3%;
            background-image: url('{{ public_path('images/pattern-blur-right.png') }}');

        }

/* Clearfix */
.invoice-info::after {
    content: "";
    display: table;
    clear: both;
}

.invoice-info {
    margin-top: 20px;
}

.invoice-info .info-block {
    width: calc(33.33% - 20px); /* Adjust for margin */
    float: left;
    margin-right: 10px; /* Equal spacing between columns */
    box-sizing: border-box; /* Include padding and border in the width */
}

.invoice-info .info-block:last-child {
    margin-right: 0;
}


    </style>
</head>

<body>


    <section id="invoice">
        <div class="container-fluid my-5 py-5">

        <div class="row pattern d-md-flex justify-content-top  py-5 py-md-3">
        <div class="d-none d-md-flex pattern-overlay pattern-right" style="background-image: url('images/pattern-blur-right.png');">
</div>

    <div class="col-md-4">
        <table style="width: 100%; margin-top: -5rem">
    
            <tr>
            <td style=" padding: 10px; text-align: left;">
                    <img src="{{ public_path('images/logoo.png') }}" alt="" style="max-width: 15%;">
                </td>
            <td style="">
                    <p class="text-primary fw-bold">Invoice No</p>
                    <h5>{{ $invoice->invoice_number }}</h5>
                </td>
            
            </tr>
            <tr>
                <td><h2><strong>INVOICE</strong></h2></td>
                <td style=" ;">
                    <p class="text-primary fw-bold">Invoice Date</p>
                    <h5>{{ $invoice->invoice_date }}</h5>
                </td>
              <!-- Empty cell for logo column -->
            </tr>
            <tr>
                <td></td>
                <td style="">
                    <p class="text-primary fw-bold">Due Date</p>
                    <h5>{{ $invoice->due_date }}</h5>
                </td>
                           </tr>
        </table>
    </div>
</div>

<hr style="border-top: 1px solid white;">



                <div class="invoice-info">
    <table style = "width: 100%; table-layout:fixed">
        <tr>
            <td style="padding: 10px; width: 33%">
                <p class="text-primary fw-bold">Invoice To</p>
                <h4>{{ $invoice->customer->name }}</h4>
                <ul class="list-unstyled">
                    <li>{{ $invoice->customer->contact_person }}</li>
                    <li>{{ $invoice->customer->email }}</li>
                    <li>{{ $invoice->customer->address }}</li>
                </ul>
            </td>
            <td style="padding: 10px;  width: 33%">
                <p class="text-primary fw-bold">Invoice From</p>
                <h4><strong>Graphics by slktstr.</strong></h4>
                <ul class="list-unstyled">
                    <li>Tokelo Foso</li>
                    <li>graphics@tokelofoso.online</li>
                    <li>Ha Matala Phase 2</li>
                </ul>
            </td>
            <td style="padding: 10px;  width: 33%">
                <p class="text-primary fw-bold">Contact Us</p>
                <h4>Contact Info</h4>
                <ul class="list-unstyled">
                    <li><iconify-icon class="social-icon text-primary fs-5 me-2" icon="mdi:location"
                            style="vertical-align:text-bottom"></iconify-icon> Ha Matala Phase 2</li>
                    <li><iconify-icon class="social-icon text-primary fs-5 me-2" icon="solar:phone-bold"
                            style="vertical-align:text-bottom"></iconify-icon> (+266) 5676 9106</li>
                    <li><iconify-icon class="social-icon text-primary fs-5 me-2" icon="ic:baseline-email"
                            style="vertical-align:text-bottom"></iconify-icon> graphics@tokelofoso.online</li>
                </ul>
            </td>
        </tr>
    </table>
</div>

<hr style="border-top: 1px solid white;">


<table class="table table-borderless table-striped my-5">
    <thead>
        <tr class="bg-primary">
            <th scope="col">No.</th>
            <th scope="col">Product Name</th>
            <th scope="col">Description</th>
            <th scope="col">Quantity</th>
            <th scope="col">Price</th>
            <th scope="col">Sub Total</th>
        </tr>
    </thead>
    <tbody>
        @php
            $total = 0;
        @endphp
        @foreach ($invoice->items as $index => $item)
            <tr>
                <td class="text-white">{{ $index + 1 }}</td>
                <td class="text-white">{{ $item->product->name }}</td>
                <td class="text-white">{{ $item->product->description }}</td>
                <td class="text-white">{{ $item->quantity }}</td>
                <td class="text-white">{{ number_format($item->product->price, 2) }}</td>
                <td class="text-white">{{ number_format($item->product->price * $item->quantity, 2) }}</td>
            </tr>
            @php
                $total += $item->product->price * $item->quantity;
            @endphp
        @endforeach
        <tr>
            <td class="text-white"></td>
            <td class="text-white"></td>
            <td class="text-white"></td>
            <td class="text-white"></td>
            <td class="text-white">Total</td>
            <td class="text-white"><strong>M{{ number_format($total, 2) }}</strong></td>
        </tr>
    </tbody>
</table>



            <!-- Other sections of the invoice -->

        </div>
    </section>

    <!-- Bootstrap Bundle JS -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

</body>

</html>
