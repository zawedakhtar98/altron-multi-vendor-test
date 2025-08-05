@extends('layout.app')



@section('main')
<div class="container my-5">
    @if (isset($cartItems) && count($cartItems)>0)
        
    <h4 class="mb-4">🛒 My Cart</h4>
    @php  $Grand_total =0; @endphp
    @foreach($cartItems as $sellerId => $items)
    <div class="vendor-cart mb-5">
        <p><b>{{ $items->first()->product->seller->name }}'s Products</b></p>

        <table class="table table-bordered mt-2">
            <thead class="table-dark">
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
            @php $vendorTotal = 0;  @endphp            
            @foreach($items as $cartItem)
                @php
                    $subtotal = $cartItem->quantity * $cartItem->price;
                    $vendorTotal += $subtotal;
                    $Grand_total+=$subtotal;
                @endphp
                <tr>
                    <td>{{ $cartItem->product->name }}</td>
                    <td class="d-flex text-center">
                        <button class="btn btn-outline-primary plus_cartqty" id="plus_qty_{{$cartItem->id}}" data-cartid="{{$cartItem->id}}">+</button>
                        <input type="number" class="form-control" name="quantity" id="inputid_{{$cartItem->id}}" value="{{ $cartItem->quantity }}" style="width: 10%">
                        <button class="btn btn-outline-primary minus_cartqty"  id="minus_qty_{{$cartItem->id}}" data-cartid="{{$cartItem->id}}">-</button>
                    </td>
                    <td>₹{{ number_format($cartItem->price, 2) }}</td>
                    <td>₹{{ number_format($subtotal, 2) }}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-end">Total:</th>
                    <th>₹{{ number_format($vendorTotal, 2)}}</th>
                </tr>
            </tfoot>
        </table>
    </div>    
    @endforeach
    
    <div class="text-end mt-3">
        <h4>Grand Total: ₹{{ number_format($Grand_total, 2) }}</h4>
        <a href="{{ url('checkout') }}" class="btn btn-success mt-2">Proceed to Checkout</a>
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
        $('.remove-cart').on('click',function(){
            let cart_id = $(this).data('cart_id');
            $.ajax({
                url:'{{url("cart/remove")}}'+'/'+cart_id,
                type:'post',
                data:{_token:'{{csrf_token()}}'},
                dataType:'JSON',
                success:function(res){
                    if(res.status){
                         Command: toastr["success"](res.message);
                         window.location.reload();
                    }
                    else{
                        Command: toastr["error"](res.message);
                        window.location.reload();
                    }
                }
            })
        })

        $('.plus_cartqty').on('click',function(){            
            let cartItemId = $(this).data('cartid');
            let quantity = parseInt($('#inputid_'+cartItemId).val());            
            quantity+=1;
            $('#inputid_'+cartItemId).val(quantity);
            $.ajax({
                url:'{{url("cart/update")}}',
                type:'post',
                data:{_token:'{{csrf_token()}}',cartitem:cartItemId,quantity:quantity},
                dataType:'JSON',
                success:function(res){
                    if(res.status){
                         Command: toastr["success"](res.message);
                         window.location.reload();
                    }
                    else{
                        Command: toastr["error"](res.message);
                        window.location.reload();
                    }
                }
            })
        })

        $('.minus_cartqty').on('click',function(){
            let cartItemId = $(this).data('cartid');
            let quantity = parseInt($('#inputid_'+cartItemId).val());            
            quantity-=1;
            if(quantity<=0){
                $('#inputid_'+cartItemId).val(1)
                Command: toastr["error"]("Quantity should be equal to 1");
            }
            else{
                $('#inputid_'+cartItemId).val(quantity);
                $.ajax({
                    url:'{{url("cart/update")}}',
                    type:'post',
                    data:{_token:'{{csrf_token()}}',cartitem:cartItemId,quantity:quantity},
                    dataType:'JSON',
                    success:function(res){
                        if(res.status){
                            Command: toastr["success"](res.message);
                            window.location.reload();
                        }
                        else{
                            Command: toastr["error"](res.message);
                            window.location.reload();
                        }
                    }
                })
            }
        });
    </script>
@endsection