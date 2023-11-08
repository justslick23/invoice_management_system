@extends('layouts.app')

@section('content')
    <h1>Create New Invoice</h1>

    <form action="{{ route('invoice.store') }}" method="post">
        @csrf

        <div class="form-group">
            <label for="invoice_number">Invoice Number:</label>
            <input type="text" name="invoice_number" id="invoice_number" value = '{{$newInvoiceNumber}}' class="form-control" readonly>
        </div>

        <div class="form-group">
            <label for="customer_id">Customer:</label>
            <select name="customer_id" id="customer_id" class="form-control">
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="invoice_date">Invoice Date:</label>
            <input type="date" name="invoice_date" id="invoice_date" class="form-control">
        </div>

        <div class="form-group">
    <label for="due_date">Due Date:</label>
    <input type="date" name="due_date" id="due_date" class="form-control">
</div>

        <!-- Add form fields for other invoice details as needed -->

        <br>
        <!-- Section for adding items -->
        <h2>Invoice Items</h2>

   

<table class="table" id="invoice-items-table">
    <thead>
        <tr>
            <th>Product</th>
            <th>Description</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Subtotal</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <select name="product_id[]" class="form-control">
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </td>
            <td><input type="text" name="item_description[]" class="form-control"></td>
            <td><input type="number" name="item_quantity[]" class="form-control quantity" value="1"></td>
            <td><input type="number" name="item_price[]" class="form-control price"></td>
            <td><span class="subtotal">0</span></td>
            <td><button type="button" class="btn btn-danger remove-row">Remove</button></td>
        </tr>
    </tbody>
</table>

<button type="button" class="btn btn-primary" id="add-item">Add Item</button>

<!-- Total and Subtotal Fields -->
<div class="text-right">
<div class="form-group" >
    <label for="subtotal" style="font-weight: bold; font-size: 1.2rem;">Subtotal:</label>
    <span id="subtotal-amount" style="font-weight: bold; font-size: 1.2rem; color: #333;">0</span>
</div>
<hr>
<div class="form-group">
    <label for="total" style="font-weight: bold; font-size: 1.2rem;">Total:</label>
    <span id="total-amount" style="font-weight: bold; font-size: 1.2rem; color: #333;">0</span>
</div>

</div>


<button type="submit" class="btn btn-primary">Create Invoice</button>
</form>
@endsection

@push('js')
<script>
    $(document).ready(function () {
        // Add item row
        $('#add-item').off().on('click', function () {
            var newRow = $('<tr>' +
                '<td><select name="product_id[]" class="form-control">@foreach($products as $product)<option value="{{ $product->id }}">{{ $product->name }}</option>@endforeach</select></td>' +
                '<td><input type="text" name="item_description[]" class="form-control"></td>' +
                '<td><input type="number" name="item_quantity[]" class="form-control quantity" value="1"></td>' +
                '<td><input type="number" name="item_price[]" class="form-control price"></td>' +
                '<td><span class="subtotal">0</span></td>' +
                '<td><button type="button" class="btn btn-danger remove-row">Remove</button></td>' +
                '</tr>');

            $('#invoice-items-table tbody').append(newRow);

            // Rebind the input event to the newly added row for live updates
            bindInputEvent(newRow);
        });

        // Remove item row
        $('#invoice-items-table').on('click', '.remove-row', function () {
            $(this).closest('tr').remove();
            updateTotals();
        });

        // Bind input event to input elements for live updates
        function bindInputEvent(row) {
            row.find('.quantity, .price').on('input', function () {
                updateTotals();
            });
        }

        // Initial binding for the first row
        bindInputEvent($('#invoice-items-table tbody tr'));

        // Update totals when input fields change
        function updateTotals() {
            var subtotal = 0;

            $('.quantity').each(function () {
                var quantity = parseFloat($(this).val());
                var price = parseFloat($(this).closest('tr').find('.price').val());
                var itemSubtotal = quantity * price;
                $(this).closest('tr').find('.subtotal').text(itemSubtotal.toFixed(2));
                subtotal += itemSubtotal;
            });

            var total = subtotal;

            $('#subtotal-amount').text(subtotal.toFixed(2));
            $('#total-amount').text(total.toFixed(2));
        }
    });
</script>


@endpush