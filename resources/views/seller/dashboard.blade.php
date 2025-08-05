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
            <div class="col-md-4">
                <div class="card bg-primary text-white p-3">
                    <div class="d-flex justify-content-between">
                        <h5>Total Users</h5>
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                    <h3>1,245</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white p-3">
                    <div class="d-flex justify-content-between">
                        <h5>Total Orders</h5>
                        <i class="fas fa-shopping-cart fa-2x"></i>
                    </div>
                    <h3>785</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-warning text-white p-3">
                    <div class="d-flex justify-content-between">
                        <h5>Pending Requests</h5>
                        <i class="fas fa-exclamation-circle fa-2x"></i>
                    </div>
                    <h3>12</h3>
                </div>
            </div>
        </div>
    </div>

</section>
@endsection