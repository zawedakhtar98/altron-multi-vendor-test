@extends('seller.layout.app')
@section('title', 'Product')
@section('seller-main')

<section>   
    <!-- Main Content -->
    <div class="content">
        <nav class="navbar navbar-light bg-white shadow-sm mb-4 p-3 rounded">
            <h3>Dashboard Overview</h3>
        </nav>

        <div class="row">
            <div class="col-md-6">
                <div class="card bg-primary text-white p-3">
                    <div class="d-flex justify-content-between">
                        <h5>Orders Count</h5>
                        <i class="fas fa-list fa-2x"></i>
                    </div>
                    <h3>{{$order_count}}</h3>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-success text-white p-3">
                    <div class="d-flex justify-content-between">
                        <h5>Product Count</h5>
                        <i class="fas fa-shopping-cart fa-2x"></i>
                    </div>
                    <h3>{{$product_count}}</h3>
                </div>
            </div>
        </div>
    </div>

</section>
@endsection