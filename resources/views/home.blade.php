@extends('layouts.app')

@section('title')
    {{ __("Home") }}
@endsection

@section('content')
<div class="container">
    <h2 class="display-2">Coalition Laravel Test</h2>

    @include('notifications')

    <br>
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('product.store') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <strong>Create A New Product</strong>
                    </div>
                    <div class="card-body">

                        <div class="mb-3">
                            <label for="product_name" class="form-label">Product Name:</label>
                            <input type="text" class="form-control" name="name" placeholder="Product Name" required>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity In Stock:</label>
                            <input type="number" class="form-control" name="quantity" placeholder="Quantity" required>
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Price per Item:</label>
                            <input type="number" class="form-control" name="price" placeholder="Price per item" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Save Product</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <br><br>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <strong>List of Items</strong>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Quantity in stock</th>
                                <th scope="col">Price per item</th>
                                <th scope="col">Datetime submitted</th>
                                <th scope="col">Total Value</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                            <tr>
                                <th scope="row">{{ $product['count'] }}</th>
                                <td>{{ $product['name'] }}</td>
                                <td>{{ $product['quantity'] }}</td>
                                <td>{{ $product['price'] }}</td>
                                <td>{{ $product['submitted'] }}</td>
                                <td>{{ $product['total_value'] }}</td>
                                <td>
                                    <button class="btn btn-primary btn-xs">Edit</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <br>
</div>
@endsection