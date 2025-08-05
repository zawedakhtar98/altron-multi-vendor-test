@if (count($product)>0)
<div class="row g-4 mt-2">
        @foreach ($product as $val)            
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="product-card">
                <img src="{{asset('storage/sellers_product_images/'.$val->image)}}" alt="Product 1" class="product-image">
                <div class="p-3 text-center">
                    <h5 class="mb-1">{{$val->name}}</h5>
                    <p class="product-price mb-2">{{$val->price}}</p>
                    <div class="d-flex justify-content-center gap-2">
                        <a href="javascript:void(0)" class="btn btn-sm btn-primary add-to-cart-btn" data-prodid="{{$val->id}}">Add to Cart</a>
                        <a href="javascript:void(0)" data-prodid="{{$val->id}}" class="btn btn-sm btn-buy text-white buy_now">Buy Now</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach  
</div>          
    @endif