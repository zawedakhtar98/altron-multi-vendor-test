@extends('admin.layout.app')
@section('title', 'Product')
@section('backend-main')

<section>   
    <!-- Main Content -->
    <div class="content">
        <nav class="navbar navbar-light bg-white shadow-sm mb-4 p-3 rounded">
            <h5>Order List</h5>                       
        </nav>
        <div class="w-100"></div>
        <div class="card">
            <div class="card-body mt-4 mb-3">
                {{-- <form action="#" id="search-order">
                <div class="row g-4 mt-3 mb-4">
                        <div class="col-md-3">
                            <select name="seller_name" id="seller-name" class="form-control">
                                <option value="">Select Seller Name</option>
                                @foreach ($customer as $val)
                                    <option value="{{$val->id}}">{{$val->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="customer_name" id="customer-name" class="form-control">
                                <option value="">Select Customer Name</option>
                                @foreach ($seller as $val)
                                    <option value="{{$val->id}}">{{$val->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="order_status" class="form-control">
                                <option value="">Select Order Status</option>
                                <option value="pending">Pending</option>
                                <option value="order place'">Order Place</option>
                                <option value="complete">Complete</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="submit" class="btn btn-primary w-100" value="Search">
                        </div>
                    </div>
                </form> --}}
                <table class="table table-responsive " id="productList">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Order Id</th>
                        <th>Customer Name</th>
                        <th>Seller Name</th>
                        <th>Order Value</th>
                        <th>Order Status</th>
                        <th>Shipping Address</th>
                        <th>Billing Address</th>
                        <th>Payment Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($orders) && count($orders)>0)
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($orders as $val)                
                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$val->id}}</td>
                        <td>{{$val->customer->name}}</td>
                        <td>{{$val->seller->name}}</td>
                        <td>{{$val->total_amount}}</td>
                        <td>{{$val->status}}</td>
                        <td>{{($val->shipping_address) ? $val->shipping_address : '-'}}</td>
                        <td>{{($val->billing_address) ? $val->billing_address : '-'}}</td>
                        <td>{{$val->payment_status}}</td>
                        <td><button class="view-order-items btn btn-sm btn-primary" data-id="{{$val->id}}"> Order Item</button></td>
                    </tr>
                    @php
                        $i++;
                    @endphp
                    @endforeach
                    @else
                    <tr>
                        <td colspan="7" class="text-center">No Products Found</td>
                    @endif
                </tbody>
            </table>
            {{-- {{$orders->links()}} --}}
            </div>
        </div>
    </div>
<!-- Order Items Modal -->
<div class="modal fade" id="orderItemsModal" tabindex="-1" aria-labelledby="orderItemsLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderItemsLabel">Order Items</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="orderItemsContent">
                    <p class="text-center">Loading...</p>
                </div>
            </div>
        </div>
    </div>
</div>

</section>
@endsection

@section('javascript') 
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
         $('#productList').DataTable();
        $('#search-order').on('submit',function(e){
            e.preventDefault();
            let formData = $(this).serialize();
            console.log(formData);
        }); 
    });

    $(document).on('click', '.view-order-items', function () {
    let orderId = $(this).data('id');

    // Show modal with loading text
    $('#orderItemsModal').modal('show');
    $('#orderItemsContent').html('<p class="text-center">Loading...</p>');

    $.ajax({
        url: '/admin/orders/' + orderId + '/items', // route to get items
        type: 'GET',
        success: function (res) {
            $('#orderItemsContent').html(res);
        },
        error: function () {
            $('#orderItemsContent').html('<p class="text-danger">Failed to load order items.</p>');
        }
    });
});

</script>
@endsection