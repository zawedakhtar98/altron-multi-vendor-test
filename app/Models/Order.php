<?php

namespace App\Models;

use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable =[
        'user_id',
        'total_amount',
        'shipping_address',
        'billing_address',
        'status',
        'seller_id',
        'payment_status'
    ];

    public function orderItem(){
        return $this->hasMany(OrderItem::class);
    }

    public function payments(){
        return $this->hasOne(Payment::class);
    }

    public function customer(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function seller(){
        return $this->belongsTo(User::class,'seller_id');
    }
}
