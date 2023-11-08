@extends('layouts.app')

@section('content')
@if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <h1>List of Quotes</h1>

    <a href="{{ route('quote.create') }}" class="btn btn-primary">Create New Quote</a>

    <table class="table">
        <thead>
            <tr>
                <th>Quote Number</th>
                <th>Customer Name</th>
                <th>Total Amount</th>
                <th>Actions</th>

                <!-- Add more columns as needed -->
            </tr>
        </thead>
        <tbody>
            @foreach($quotes as $quote)
                <tr>
                    <td>{{ $quote->quote_number }}</td>
                    <td>{{ $quote->customer->name }}</td>
                    <td>M{{ $quote->total }}</td>
                   
<td>
    <a href="{{ route('invoice.edit', $quote->id) }}" class="btn btn-primary btn-sm">
        <i class="fas fa-edit"></i>
    </a>
    <a href="{{ route('invoice.download', $quote->id) }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-download"></i>
    </a>
    <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#recordPaymentModal">
        <i class="fas fa-money-bill"></i> 
    </button>
    <form method="post" action="{{ route('invoice.destroy', $quote->id) }}" style="display: inline;">
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



@endsection
