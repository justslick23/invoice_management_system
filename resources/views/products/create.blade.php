@extends('layouts.app')

@section('content')
    <h1>Create New Product</h1>

    <form action="{{ route('product.store') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" class="form-control">
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea name="description" id="description" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" name="price" id="price" class="form-control">
        </div>

        <!-- Add form fields for other product details as needed -->

        <button type="submit" class="btn btn-primary">Create Product</button>
    </form>
@endsection
