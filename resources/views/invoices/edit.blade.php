@extends('layouts.app')

@section('content')
    <h1>Edit Invoice</h1>

    <form action="{{ route('invoice.update', $invoice->id) }}" method="post">
        @csrf
        @method('PUT')

        <!-- Display and edit invoice data -->
        <div class="form-group">
            <label for="invoice_number">Invoice Number:</label>
            <input type="text" name="invoice_number" id="invoice_number" value="{{ $invoice->invoice_number }}" class="form-control" readonly>
        </div>

        <div class="form-group">
            <label for="customer_id">Customer:</label>
            <select name="customer_id" id="customer_id" class="form-control">
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}" {{ $customer->id == $invoice->customer_id ? 'selected' : '' }}>
                        {{ $customer->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
    <label for="invoice_status">Invoice Status:</label>
    <select name="invoice_status" id="invoice_status" class="form-control">
        <option value="draft" {{ $invoice->status == 'Unpaid' ? 'selected' : '' }}>Unpaid</option>
        <option value="sent" {{ $invoice->status == 'Partially Paid' ? 'selected' : '' }}>Partially Paid</option>
        <option value="paid" {{ $invoice->status == 'Paid' ? 'selected' : '' }}>Paid</option>
        <!-- Add more status options as needed -->
    </select>
</div>


        <div class="form-group">
            <label for="invoice_date">Invoice Date:</label>
            <input type="date" name="invoice_date" id="invoice_date" value="{{ $invoice->invoice_date }}" class="form-control">
        </div>

          <!-- Invoice Items table -->
        <!-- Invoice Items table -->
<h2>Invoice Items</h2>
<table class="table" id="invoice-items-table">
    <thead>
        <tr>
            <th>Product</th>
            <th>Description</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($invoice->items as $item)
            <tr>
                <td>
                    <select name="product_id[]" class="form-control">
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ $product->id == $item->product->id ? 'selected' : '' }}>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <td><input type="text" name="item_description[]" class="form-control" value="{{ $item->product->description }}"></td>
                <td><input type="number" name="item_quantity[]" class="form-control quantity" value="{{ $item->quantity }}"></td>
                <td><input type="number" name="item_price[]" class="form-control price" value="{{ $item->product->price }}"></td>
                <td><span class="subtotal">{{ $item->quantity * $item->product->price }}</span></td>
            </tr>
        @endforeach
    </tbody>
</table>



        <!-- Add form fields for other invoice details as needed -->

        <!-- Save Changes button -->
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
@endsection
