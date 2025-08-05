<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CustomerShipBillAdd;
use App\Models\Product;
use App\Services\CartService;
use App\Services\CheckoutService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Validator;

class CustomerController extends Controller
{
     protected $cartService;
    protected $checkservice;

    public function __construct(CartService $cartService, CheckoutService $checkservice)
    {
        $this->cartService = $cartService;
        $this->checkservice = $checkservice;
    }

    public function product_list(Request $request){
        $product = Product::orderByDesc('id')->paginate(20);
        if ($request->ajax()) {
            return view('customer.ajax.product-list', compact('product'))->render();
        }
        return view('customer.product',compact('product'));
    }

    public function addToCart($id){
        return $this->cartService->addToCart($id);
    }

    public function cartCount(){
        return response()->json(['count'=>$this->cartService->TotalCartCount()]);
    }


    public function viewCart(){
        $cartItems = $this->cartService->viewCart();
        return view('customer.view-cart',compact('cartItems'));
    }

    public function removeCart($id){
        return $this->cartService->removeCart($id);
    }

    public function updateCartItem(Request $request){  
        return $this->cartService->updateCartItem($request->cartitem,$request->quantity);
    }

    public function checkout()
    {
        $cart = Cart::with('cartItem.product')->where('user_id', auth()->id())->first();
        return view('customer.checkout',compact('cart'));
    }

    public function OrderPlace(Request $request){

        $validator = Validator::make($request->all(), [
            'shipping_address' => 'required|max:255',
            'payment_method' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json(['status'=>false,'message'=>'Please enter shiping address and select payment method']);
        }
       return $this->checkservice->checkout($request->shipping_address,$request->payment_method);
    }
    
}
