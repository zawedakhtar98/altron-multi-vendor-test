@extends('seller.layout.app')
@section('title', 'Product')
@section('seller-main')

<section>   
    <!-- Main Content -->
    <div class="content">
        <nav class="navbar navbar-light bg-white shadow-sm mb-4 p-3 rounded">
            <h5>Product List</h5>
            <a href="{{route('seller.product.add')}}" class="btn btn-success float-end"><i class="fas fa-plus"></i>  Add Product</a>
        </nav>
        <div class="w-100"></div>
        <div class="card">
            <div class="card-body">
                <table class="table table-responsive" id="productList">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>In Stock</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($product) >0)
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($product as $val)                
                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$val->name}}</td>
                        <td>{{$val->price}}</td>
                        <td>{{$val->in_stock}}</td>
                        <td><a href="#">View Product Image</a></td>
                        <td><a href="#">Edit</a></td>
                    </tr>
                    @php
                        $i++;
                    @endphp
                    @endforeach
                    @else
                    <tr>
                        <td colspan="4" class="text-center">No Products Found</td>
                    @endif
                </tbody>
            </table>
            {{$product->links()}}
            </div>
        </div>
    </div>

</section>
@endsection

@section('javascript') 
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        // $('#productList').DataTable();
    });
</script>
@endsection