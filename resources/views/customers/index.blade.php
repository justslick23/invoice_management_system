@extends('layouts.app')

@section('content')
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

                    <!-- Add more columns as needed -->
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@push('js')
<link href="https://cdn.datatables.net/v/bs5/jq-3.7.0/jszip-3.10.1/dt-1.13.7/af-2.6.0/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/cr-1.7.0/date-1.5.1/fc-4.3.0/fh-3.4.0/r-2.5.0/sb-1.6.0/datatables.min.css" rel="stylesheet">
 
 <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
 <script src="https://cdn.datatables.net/v/bs5/jq-3.7.0/jszip-3.10.1/dt-1.13.7/af-2.6.0/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/cr-1.7.0/date-1.5.1/fc-4.3.0/fh-3.4.0/r-2.5.0/sb-1.6.0/datatables.min.js"></script>

<script>
   $(document).ready(function() {
            $('#customers-table').DataTable({

            }); 

        });
    </script>


@endpush