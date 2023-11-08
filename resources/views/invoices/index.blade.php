@extends('layouts.app')

@section('content')
@if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <h1>List of Invoices</h1>

    <a href="{{ route('invoice.create') }}" class="btn btn-primary">Create New Invoice</a>

    <table class="table">
        <thead>
            <tr>
                <th>Invoice Number</th>
                <th>Customer Name</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Actions</th>

                <!-- Add more columns as needed -->
            </tr>
        </thead>
        <tbody>
            @foreach($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->invoice_number }}</td>
                    <td>{{ $invoice->customer->name }}</td>
                    <td>M{{ $invoice->total }}</td>
                    <td>
    @if($invoice->status === 'paid')
        <span class="badge badge-success">{{ $invoice->status }}</span>
    @elseif($invoice->status === 'pending')
        <span class="badge badge-warning">{{ $invoice->status }}</span>
    @else
        <span class="badge badge-danger">{{ $invoice->status }}</span>
    @endif
</td>
<td>
    <a href="{{ route('invoice.edit', $invoice->id) }}" class="btn btn-primary btn-sm">
        <i class="fas fa-edit"></i>
    </a>
    <a href="{{ route('invoice.download', $invoice->id) }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-download"></i>
    </a>
    <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#recordPaymentModal">
        <i class="fas fa-money-bill"></i> 
    </button>
    <form method="post" action="{{ route('invoice.destroy', $invoice->id) }}" style="display: inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this invoice?')">
            <i class="fas fa-trash-alt"></i>
        </button>
    </form>
</td>


                    <!-- Add more columns as needed -->
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="modal fade" id="recordPaymentModal" tabindex="-1" role="dialog" aria-labelledby="recordPaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="recordPaymentModalLabel">Record Payment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Payment Form -->
                <form action="{{ route('invoice.recordPayment', $invoice->id) }}" method="post">
                    @csrf

                 
                    <div class="form-group">
                        <label for="payment_amount">Payment Amount:</label>
                        <input type="number" name="payment_amount" id="payment_amount" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="payment_date">Payment Date:</label>
                        <input type="date" name="payment_date" id="payment_date" class="form-control" required>
                    </div>
                    <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                    <button type="submit" class="btn btn-success">Save Payment</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


@endsection
