@extends('layout.app')

@section('main')
<div class="container my-5">

    <h2 class="mb-4">Checkout</h2>
    @if(isset($cart) && $cart->count()>0)
    <div class="row">
        <!-- Shipping Address Section -->
        <div class="col-lg-7 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    Shipping Address
                </div>
                <div class="card-body">
                <form id="order_place_form">
                    @csrf
                   <div class="form-group mt-2 mb-2">
                        <input type="text" class="form-control" name="shipping_address" placeholder="Shipping address">       
                    </div> 
                    <div class="form-group mt-2 mb-2">
                        <select name="payment_method" class="form-control" id="payment_method">
                            <option value="cod">Cash on delivery</option>
                            <option value="online">Online</option>
                        </select>
                </div>
                    
                </div>
            </div>
        </div>

        <!-- Cart Items Section -->
        <div class="col-lg-5">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-dark text-white">
                    Your Cart
                </div>
                <div class="card-body">
                    @php $grandTotal = 0; @endphp

                    
                        <div class="mb-4">
                            <table class="table table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Product</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cart->cartItem as $item)
                                        @php 
                                            $subtotal = $item->quantity * $item->price;
                                            $grandTotal += $subtotal;
                                        @endphp
                                        <tr>
                                            <td>{{ $item->product->name }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>₹{{ number_format($item->price, 2) }}</td>
                                            <td>₹{{ number_format($subtotal, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    Order Summary
                </div>
                <div class="card-body">
                    <h5>Grand Total: <span class="float-end">₹{{ number_format($grandTotal, 2) }}</span></h5>
                        <div class="d-flex g-4 mt-5 mb-2">
                            <a href="{{url('cart/view')}}" class="btn btn-info me-2">View Cart</a>       
                            <button type="submit" id="order-process-btn" class="btn btn-success ms-3">Place Order</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
    @else
    <div class="alert alert-info text-center">
            Your cart is empty
        </div>
        <div class="text-center mt-3">
            <a href="{{ url('/') }}" class="btn btn-primary">Continue Shopping</a>
        </div>
    @endif
</div>
@endsection

@section('javascript')
    <script>
        $('#order_place_form').on('submit',function(e){
            e.preventDefault();
            let data = $(this).serialize();
            $.ajax({
                url:'{{route("order-place")}}',
                type:'post',
                data:data,
                beforeSend:function(){
                    $('#order-process-btn')
                    .prop('disabled', true)
                    .text('Processing...');
                },
                success:function(res){
                    if(res.status){
                         Command: toastr["success"](res.message);
                        setTimeout(() => {
                            window.location.href = '{{ url("/") }}'; 
                        }, 3000);
                    }
                    else{
                        Command: toastr["error"](res.message);
                        // window.location.reload();
                    }
                },
                complete: function () {
                    $('#order-process-btn')
                        .prop('disabled', false)
                        .text('Place Order');
                }
            })
        })
    </script>
@endsection