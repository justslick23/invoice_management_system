@extends('layouts.app')

@section('content')
@if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <h1>List of Invoices</h1>

    <a href="{{ route('invoice.create') }}" class="btn btn-primary">Create New Invoice</a>

    <table class="table" id = 'invoices-table'>
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

@push('js')
 

  
<link href="https://cdn.datatables.net/v/dt/jq-3.7.0/jszip-3.10.1/dt-1.13.7/af-2.6.0/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/b-print-2.4.2/cr-1.7.0/date-1.5.1/fc-4.3.0/fh-3.4.0/kt-2.11.0/r-2.5.0/rg-1.4.1/rr-1.4.1/sc-2.3.0/sb-1.6.0/sl-1.7.0/sr-1.3.0/datatables.min.css" rel="stylesheet">
 
 <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
 <script src="https://cdn.datatables.net/v/dt/jq-3.7.0/jszip-3.10.1/dt-1.13.7/af-2.6.0/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/b-print-2.4.2/cr-1.7.0/date-1.5.1/fc-4.3.0/fh-3.4.0/kt-2.11.0/r-2.5.0/rg-1.4.1/rr-1.4.1/sc-2.3.0/sb-1.6.0/sl-1.7.0/sr-1.3.0/datatables.min.js"></script>


<script>
        $(document).ready(function() {
            $('#invoices-table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>
    @endpush
  