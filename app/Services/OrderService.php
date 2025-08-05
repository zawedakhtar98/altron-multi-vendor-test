<?php 

namespace App\Services;

use App\Models\Order;

class OrderService{
    public function getAllOrder(){
        return Order::with('customer','seller')->orderBy('id','desc')->paginate(50);
    }
}

