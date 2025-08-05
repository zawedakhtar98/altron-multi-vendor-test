<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id', 'payment_method', 'amount', 'status', 'transaction_no'
    ];
    public function orders(){
        return $this->belongsTo(Order::class);
    }
}
