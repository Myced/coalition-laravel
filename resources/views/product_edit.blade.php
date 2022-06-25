@extends('layouts.app')

@section('title')
    {{ __("Home") }}
@endsection

@section('content')
<div class="container" id="app">
    <h2 class="display-2">Coalition Laravel Test</h2>

    @include('notifications')

    <br>
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('product.update', ['id' => $product['count']]) }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <strong>Update a product</strong>
                    </div>
                    <div class="card-body">

                        <div class="mb-3">
                            <label for="product_name" class="form-label">Product Name:</label>
                            <input type="text" class="form-control" name="name" placeholder="Product Name" 
                                required value="{{ $product['name'] }}">
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity In Stock:</label>
                            <input type="number" class="form-control" name="quantity" placeholder="Quantity" 
                                required value="{{ $product['quantity'] }}">
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Price per Item:</label>
                            <input type="number" class="form-control" name="price" placeholder="Price per item" 
                                equired value="{{ $product['price'] }}">
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Update Product</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <br>
    <br>
    
</div>
@endsection
