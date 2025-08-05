@extends('admin.layout.app')
@section('title', 'Product')
@section('backend-main')

<section>   
    <!-- Main Content -->
    <div class="content">
        <nav class="navbar navbar-light bg-white shadow-sm mb-4 p-3 rounded">
            <h5>Add Product</h5>            
            <a href="{{route('product.list')}}" class="btn btn-success float-end"><i class="fas fa-list"></i> Product List</a>
        </nav>
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    @if(session()->has('success'))
                    <div class="alert alert-success">
                        <p>{{session('success')}}</p>
                    </div>
                    @elseif(session()->has('error'))
                    <div class="alert alert-danger">
                        <p>{{session('error')}}</p>
                    </div>                        
                    @endif
                    <form method="post" action="{{route('product.save')}}" enctype="multipart/form-data" class="navbar-light bg-white shadow-sm mb-4 p-5 rounded">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" name="prouct_name" id="name" placeholder="Enter product name" required>
                            <span class="text-danger">@error('prouct_name') {{$message}}
                            @enderror</span>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="number" class="form-control" name="price" id="email" placeholder="Enter price" required>
                            <span class="text-danger">@error('price') {{$message}}
                                @enderror</span>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Upload Product Images</label>
                            <input type="file" name="images[]" multiple accept="image/gif, image/png, image/jpg, image/jpeg" class="form-control" required>
                            <span class="text-danger">@error('images') {{$message}}
                                @enderror</span>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</section>
@endsection