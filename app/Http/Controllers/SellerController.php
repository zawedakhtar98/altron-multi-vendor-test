<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Auth;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function dashboard(){
        $order_count = Order::with('seller')->where('seller_id',Auth::id())->count();
        $product_count = Product::with('seller')->where('seller_id',Auth::id())->count();
       return view('seller.dashboard',compact('order_count','product_count'));
    }

    public function addProduct(){
        return view('seller.addProduct');
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:1',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        try{
            $seller_id = Auth::id();     
            if($request->hasFile('image')){
                $image = $request->file('image');
                $imageName = time() . '-' . uniqid() . '.' . $image->extension();
                $image->storeAs("public/sellers_product_images", $imageName);

            }
            Product::create([
                'name' => $request->product_name,
                'price' => $request->price,
                'in_stock' => $request->quantity,
                'seller_id' => $seller_id,
                'image' => $imageName,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            return back()->with('success', 'Product saved successfully!');
        }
        catch(\Exception $e){
            return back()->with('error',"Something went wrong please try again!".$e->getMessage());
        }

    }

    public function productList(){
        $product = Product::where('seller_id',Auth::id())->orderBy('id','desc')->paginate(20);
        return view('seller.product_list', compact('product'));
    }
}
