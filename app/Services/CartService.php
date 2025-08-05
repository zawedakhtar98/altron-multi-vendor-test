<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Auth;
use DB;
use Illuminate\Support\Facades\Log;

class CartService{
    public function TotalCartCount(){
        $cart_count =0;
        if(Auth::check()){
            $cart = CartItem::whereHas('cart',function($query){
                $query->where('user_id',Auth::id());
            })->get();
            $cart_count+= $cart->count(); 

        }
        if(session()->has('cart')){
            $cart = session('cart');
            $cart_count+=count($cart);
        }
        return $cart_count;
    }
    public function addToCart($productId)
    {
        $product = Product::findOrFail($productId);

        if (Auth::check()) {
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

            $cartItem = CartItem::where('cart_id', $cart->id)
                                ->where('product_id', $productId)
                                ->first();                              

            if ($cartItem || isset($cart[$productId])) {
               return response()->json(['status'=>false,'message'=>"Already added into cart!"]);
            } else {
                CartItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $productId,
                    'quantity' => 1,
                    'price' => $product->price,
                    'created_at'=>now(),
                    'updated_at'=>now()
                ]);
            }
            //if any customer added into guest cart then count of cart should guest+customer count will return
            $guest_cart = 0;
            if(session()->has('cart')){
                $guest_cart = count(session('cart'));
            }
            $count = CartItem::where('cart_id', $cart->id)->count();
            return response()->json(['status'=>true,'count'=>$count+ $guest_cart]);

        } else {
            $cart = session()->get('cart', []);

            if (isset($cart[$productId])){
                 return response()->json(['status'=>false,'message'=>"Already added into cart!"]);
            } else {
                $cart[$productId] = [
                    "name" => $product->name,
                    "quantity" => 1,
                    "price" => $product->price,
                    "image" => $product->image
                ];
            }

            session()->put('cart', $cart);
            return response()->json(['status'=>true,'count'=>count($cart)]);
        }
    }

    public function viewCart(){

        $cart = Cart::with('cartItem.product.seller')
                ->where('user_id', Auth::id())
                ->first();
                if(isset($cart) && $cart->count()>0){
                    return $cart->cartItem->groupBy(function($item) {
                       return $item->product->seller->id;
                   });       
                }
        
    }
    
    public function removeCart($id){

        return  CartItem::findOrFail($id);
        if(Auth::check()){
            try{
                $cartItem = CartItem::findOrFail($id);
                if($cartItem){
                    $cartItem->delete();
                    return response()->json(['status'=>true,'message'=>'Item removed from cart!']);
                }
                else{
                    return response()->json(['status'=>false,'message'=>'Cart empty!']);
                }
            }
            catch(\Exception $e){
                return response()->json(['status'=>false,'message'=>'Something went wrong. Please try again']);
            }
        }
    }

    public function updateCartItem($cartItemId, $quantity)
    {
        $cartItem = CartItem::with('product')->findOrFail($cartItemId);
        $product = $cartItem->product;
        if (!$product) {
            return [
                'status' => false,
                'message' => 'Product not found',
                'code' => 404
            ];
        }

        if ($quantity > $product->in_stock) {
            return [
                'status' => false,
                'message' => "Only {$product->in_stock} units available for {$product->name}",
                'code' => 422
            ];
        }

        $cartItem->update([
            'quantity' => $quantity,
            'price' => $product->price, 
        ]);

        $subtotal = $cartItem->quantity * $cartItem->price;
        $cartTotal = CartItem::where('cart_id', $cartItem->cart_id)
                    ->sum(DB::raw('quantity * price'));

        return [
            'status' => true,
            'message' => 'Cart updated successfully',
            'subtotal' => $subtotal,
            'cart_total' => $cartTotal,
            'code' => 200
        ];
    }
}