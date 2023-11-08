@extends('layouts.app')

@section('content')

    <h1>Create Customer</h1>
    <form method="POST" action="{{ url('/customers') }}">
        @csrf
        <div class="form-group">
            <label for="name">Company Name:</label>
            <input type="text" name="name" id="name" class="form-control">
        </div>

        <div class="form-group">
            <label for="contact_person">Contact Person:</label>
            <input type="text"  name="contact_person" id="contact_person" class="form-control">
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" class="form-control">
        </div>
        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" name="phone" id="phone" class="form-control">
        </div>
        <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" name="address" id="address" class="form-control">
        </div>

        <!-- Add more form fields as needed -->
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
@endsection
