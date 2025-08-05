@extends('seller.layout.app')
@section('title', 'Product')
@section('seller-main')

<section>   
    <!-- Main Content -->
    <div class="content">
        <nav class="navbar navbar-light bg-white shadow-sm mb-4 p-3 rounded">
            <h5>Add Product</h5>            
            <a href="{{route('seller.product.list')}}" class="btn btn-success float-end"><i class="fas fa-list"></i> Product List</a>
        </nav>
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <form method="post" id="productForm" action="{{route('seller.product.store')}}" enctype="multipart/form-data"  class="navbar-light bg-white shadow-sm mb-4 p-5 rounded">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Product Name</label>
                            <input type="text" class="form-control" name="product_name" placeholder="Enter product name" required>
                            <span class="text-danger">@error('product_name') {{$message}}
                            @enderror</span>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Price</label>
                            <input type="number" class="form-control" name="price" placeholder="Enter product name">
                            <span class="text-danger">@error('price') {{$message}}
                            @enderror</span>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Quantity</label>
                            <input type="number" class="form-control" name="quantity" placeholder="Enter product name">
                            <span class="text-danger">@error('quantity') {{$message}}
                            @enderror</span>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Upload Product Image</label>
                            <input type="file" name="image" accept="image/gif, image/png, image/jpg, image/jpeg" class="form-control">
                            <span class="text-danger">@error('image') {{$message}}
                                @enderror</span>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</section>
@section('javascript')
<script>
        $("#productForm").validate({
            rules: {
                product_name: { required: true, minlength: 3 },
                price: { required: true, number: true, min: 1 },
                quantity: { required: true, digits: true, min: 1 },
                image: { extension: "jpg|jpeg|png|gif" }
            },
            messages: {
                product_name: { required: "Please enter a product name" },
                price: { required: "Please enter a price" },
                quantity: { required: "Please enter quantity" },
                image: { extension: "Only JPG, JPEG, PNG, GIF files are allowed" }
            },
            errorElement: "span",
            errorClass: "text-danger",
            highlight: function (element) {
                $(element).addClass("is-invalid");
            },
            unhighlight: function (element) {
                $(element).removeClass("is-invalid");
            }
        });
</script>
@endsection
@endsection