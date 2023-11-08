@extends('layouts.app')

@section('content')
@if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <h1>List of Customers</h1>
    <a href="{{ url('/customers/create') }}" class="btn btn-primary">Create New Customer</a>
    <br>
    <br>

    <table class="table" id = 'customers-table'>
        <thead>
            <tr>
                <th>Company Name</th>
                <th>Contact Person</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Actions</th> <!-- Add this column for actions -->

                <!-- Add more columns as needed -->
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $customer)
                <tr>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->contact_person }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->phone }}</td>
                    <td>{{ $customer->address }}</td>
                    <td>
                <a href="{{ route('customers.edit', $customer->id) }}" data-toggle="modal" data-target="#editModal" class="btn btn-primary">Edit</a>
                <form action="{{ route('customers.destroy', $customer->id) }}" method="post" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>

                    <!-- Add more columns as needed -->
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Button to trigger the Edit modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal">
    Edit
</button>

<!-- Edit Modal -->
@if($customer)
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <!-- resources/views/customers/edit-form.blade.php -->
<form action="{{ route('customers.update', $customer->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="name">Company Name:</label>
        <input type="text" name="name" id="name" value="{{ $customer->name }}" class="form-control">
    </div>

    <div class="form-group">
        <label for="contact_person">Contact Person:</label>
        <input type="text" name="contact_person" id="contact_person" value="{{ $customer->contact_person }}" class="form-control">
    </div>

    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="{{ $customer->email }}" class="form-control">
    </div>

    <div class="form-group">
        <label for="phone">Phone:</label>
        <input type="text" name="phone" id="phone" value="{{ $customer->phone }}" class="form-control">
    </div>

    <div class="form-group">
        <label for="address">Address:</label>
        <textarea name="address" id="address" class="form-control">{{ $customer->address }}</textarea>
    </div>

    <!-- Add more form fields as needed -->

    <button type="submit" class="btn btn-primary">Save</button>
</form>

            </div>
        </div>
    </div>
</div>
@endif

@endsection

@push('js')
<link href="https://cdn.datatables.net/v/dt/jq-3.7.0/jszip-3.10.1/dt-1.13.7/af-2.6.0/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/b-print-2.4.2/cr-1.7.0/date-1.5.1/fc-4.3.0/fh-3.4.0/kt-2.11.0/r-2.5.0/rg-1.4.1/rr-1.4.1/sc-2.3.0/sb-1.6.0/sl-1.7.0/sr-1.3.0/datatables.min.css" rel="stylesheet">
 
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/v/dt/jq-3.7.0/jszip-3.10.1/dt-1.13.7/af-2.6.0/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/b-print-2.4.2/cr-1.7.0/date-1.5.1/fc-4.3.0/fh-3.4.0/kt-2.11.0/r-2.5.0/rg-1.4.1/rr-1.4.1/sc-2.3.0/sb-1.6.0/sl-1.7.0/sr-1.3.0/datatables.min.js"></script>
<script>
 
        $('#customers-table').DataTable({
            buttons: [
                'copy', 'excel', 'pdf', 'print'
            ]
        });

</script>


@endpush