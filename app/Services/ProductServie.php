<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Category;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use PDO;

class ProductServie
{
    /**
     * Create a new class instance.
     */
    public function list($per_page=10)
    {
        // return Product::with('category')->latest()->paginate($per_page);
        return Product::with('category')->select('id','name','price','stock','category_id')->orderBy('id','desc')->paginate($per_page);
        // return Product::query()->with('category:id,name')->select('id','name','price','stock','category_id')->orderBy('id','desc')->cursorPaginate($per_page);
    }

    public function create(array $data){
        return Product::create($data);
    }

    public function singleProduct(Product $product){
        return $product;
    }

    public function update(Product $product, array $data){
        $product->update($data);
        return $product;
    }

    public function delete(Product $product){
        return $product->delete();
    }

    public function search($request){
        return Product::when($request->search,fn($q)=>
            $q->where('name','like',"%{$request->search}%")
        )
        ->latest()
        ->paginate(10);
    }

    public function filterByProductAndCategory($request)
    {
        return Product::with('category')
        ->when($request->category_id,function($q,$category_id){
            $q->where('category_id',$category_id);
        })
        ->when($request->stock,function($q,$stock){
            $q->where('stock','>=',$stock); 
        })
        ->latest()
        ->paginate(10);
    }

    public function getAllCategory(){
        return Category::all();         
    }
}
