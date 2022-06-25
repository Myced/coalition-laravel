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
            <form action="{{ route('product.store') }}" method="POST" @submit.prevent="saveItem">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <strong>Create A New Product</strong>
                    </div>
                    <div class="card-body">

                        <div class="mb-3">
                            <label for="product_name" class="form-label">Product Name:</label>
                            <input type="text" class="form-control" name="name" placeholder="Product Name" 
                                v-model="productName" required>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity In Stock:</label>
                            <input type="number" class="form-control" name="quantity" placeholder="Quantity" 
                                v-model="quantity" required>
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Price per Item:</label>
                            <input type="number" class="form-control" name="price" placeholder="Price per item" 
                                v-model="price" required>
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
                            <tr v-for="item in items">
                                <th scope="row">@{{ item.count }}</th>
                                <td>@{{ item.name }}</td>
                                <td>@{{ item.quantity }}</td>
                                <td>@{{ item.price }}</td>
                                <td>@{{ item.submitted }}</td>
                                <td>@{{ item.total_value }}</td>
                                <td>
                                    <a :href=" getBaseUrl() + '/products/' + item.count + '/edit'  " 
                                        class="btn btn-primary btn-xs">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <br>
</div>
@endsection

@section('scripts')
<script>
    var app = new Vue({
        el: '#app',
        mounted(){
            
            const productsUrl = this.getProductsUrl();

            axios.get(productsUrl)
                .then(response => this.items = response.data)
                .catch(error => {
                    alert("Error fetching items");
                    console.error(error);
                });
            
        },
        methods: {
            getBaseUrl(){
                const base_url = window.location.protocol + '//' + window.location.host;
                return base_url;
            },

            getProductsUrl()
            {
                return this.getBaseUrl() + "/api/products";
            },

            getSaveProductUrl()
            {
                return this.getBaseUrl() + "/api/products/store";
            },

            saveItem()
            {
                this.addItem();
            },

            addItem(){
                const vueapp = this;
                const name = this.productName;
                const quantity = this.quantity;
                const price = this.price;

                const url = this.getSaveProductUrl();

                //validate the form fields.
                if(name === "" || quantity === "" || price === "")
                {
                    alert("All fields are required");
                }
                else{

                    const postData = {
                        name: name,
                        quantity: quantity,
                        price: price
                    };

                    axios.post(url, postData)
                        .then(response => {
                            vueapp.items = [... vueapp.items, response.data.item];

                            //clear form fields
                            vueapp.productName = "";
                            vueapp.quantity = "";
                            vueapp.price = "";
                        })
                        .catch(error => {
                            alert("Could not save item");
                            console.error(error);
                        })

                }
            },
        },
        data: {
            items: [],
            id: null,
            productName: '',
            quantity: '',
            price: '',
        }
    })
</script>
@endsection