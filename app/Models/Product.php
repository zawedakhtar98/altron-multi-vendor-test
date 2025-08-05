<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'price',
        'quantity',
        'in_stock',
        'seller_id',
        'image',
    ];

    public function seller(){
        return $this->belongsTo(User::class, 'seller_id','id');
    }

    public function orderItem(){
        return $this->hasMany(OrderItem::class);
    }
}
