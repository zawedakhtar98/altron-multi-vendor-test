<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/',function(){  
    //syntax wise this correct but where condition work after join 
    // return DB::table('products as p')
    //         ->leftJoin('categories as c','p.category_id','=','c.id')->where('c.status','active')
    //         ->leftJoin('categories as c2','c.sub_category','=','c2.id')->where('c2.status','active')
    //         ->select('p.*','c.name as category_name','c2.name as sub_category')
    //         ->get();
            return $product_withActivecategory = DB::table('products as p')
                       ->leftJoin('categories as c',function($join){
                           $join->on('p.category_id','=','c.id')
                           ->where('c.status','active');
                       })
                       ->select('p.*','c.name as category_name')
                       ->paginate(10);
        $totalProductCountCategory = DB::table('products as p')
                                        ->leftJoin('categories as c','c.id','=','p.category_id')
                                        ->select('c.name as category_name',DB::raw('count(p.id) as product_count'))
                                        ->whereNotNull('c.id')
                                        ->groupBy('p.category_id','c.name')
                                        ->get();
        // $productWithoutCategory  = DB::table('products as p')->whereNull('p.category_id')->get();
        $productWithoutCategory  = DB::table('products as p')
                                        ->leftJoin('categories as c','c.id','=','p.category_id')
                                        ->select('p.*')
                                        ->whereNull('p.category_id')->get();
        $productAcIncCat = DB::table('products as p')
                            ->join('categories as c',function($join){
                                $join->on('c.id','=','p.category_id')
                                ->where('c.status','=','active');
                            })                                        
                            ->join('categories as c2',function($join){
                                $join->on('c2.sub_category','=','c.id')
                                ->where('c2.status','=','inactive');
                            })
                            ->select('p.*','c.name as category_name','c2.name as sub_category')
                            ->get();  
    return  [
                'totalProductCountCategory'=>$totalProductCountCategory,
                'product_withActivecategory'=>$product_withActivecategory,
                'productWithoutCategory'=>$productWithoutCategory,
                'productAcIncCat'=>$productAcIncCat
            ];
});