<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    public $fillable = [
        'name',
        'stock',
        'price',
        'created_at',
        'updated_at',
        'category_id'
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
