<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Services\OrderService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $orderservice;

    public function __construct(OrderService $orderservice){
        $this->orderservice = $orderservice;
    }

    public function dashboard(){
        $customer_count = User::where('role','customer')->count();
        $seller_count = User::where('role','seller')->count();
        $order_count = Order::count();
        return view('admin.dashboard',compact('customer_count','seller_count','order_count'));
    }


    public function ProductList(){
        $product = Product::with('seller')->orderBy('id','desc')->paginate(20);
        return view('admin.product_list',compact('product'));
    }

    public function getAllOrders(){
         $orders = $this->orderservice->getAllOrder();
         $customer = User::select('id','name')->where('role','customer')->get();
         $seller = User::select('id','name')->where('role','seller')->get();
         return view('admin.order_list',compact('orders','customer','seller'));
    }

    public function filterOrder(Request $request){
        $customer_name = $request->customer_name;
        $seller_name = $request->seller_name;
        $order_status = $request->order_status;
        if(!empty($customer_name) || !empty($seller_name) || !empty($order_status)){
            
        }
    }

    public function orderItems($orderId)
    {
        $order = Order::with('orderItem.product')->findOrFail($orderId);

        return view('admin.order-items', compact('order'));
    }

    
}
