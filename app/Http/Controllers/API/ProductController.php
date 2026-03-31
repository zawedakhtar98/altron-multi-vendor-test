<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductServie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use PDO;

set_time_limit(0);

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $productService;
    public function __construct(ProductServie $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $products = $this->productService->list(10);
        // return response()->json([
        //     'success' => true,
        //     'message' => 'Fetch successfully!',
        //     'data' => ProductResource::collection($products),
        //     'meta'=>[
        //         'current_page'=> $products->currentPage(),
        //         'last_page'=> $products->lastPage(),
        //         'per_page'=> $products->perPage(),
        //         'total'=> $products->total(),
        //     ],
        //     'links'=>[
        //         'next'=>$products->nextPageUrl(),
        //         'prev'=>$products->previousPageUrl()
        //     ]
        // ]);

        return ProductResource::collection($products)->additional([
            'success'=>true,
            'message'=>'Fetch Successfully!'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $product = $this->productService->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Product created!',
            'data' => new ProductResource($product)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $product =  Product::findOrFail($id);
            $product = $this->productService->singleProduct($product);
            return response()->json([
                'status' => true,
                'message' => 'Fetch successfully!',
                'data' => new ProductResource($product),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Record not found!',
                'data' => []
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        // dd($request->all());
        $product = $this->productService->update($product, $request->validated());
        Log::info("update request", $request->validated());
        return response()->json([
            'success' => true,
            'message' => 'Product updated',
            'data' => new ProductResource($product)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully'
        ], 200);
    }

    public function search(Request $request)
    {
        $product = $this->productService->search($request);
        return response()->json([
            'status' => true,
            'message' => 'Record Fetched!',
            'data' => ProductResource::Collection($product)
        ]);
    }

    public function filterByProductAndCategory(Request $request)
    {
        try {
            $cacheKey = 'products_'.md5(json_encode($request->all()));
            Log::info($cacheKey);
            // $product = $this->productService->filterByProductAndCategory($request);        
            $product = Cache::remember($cacheKey,60,function() use ($request){
                return $this->productService->filterByProductAndCategory($request);        

            });
            return response()->json([
                'status' => true,
                'message' => 'Record Fetched!',
                'data' => ProductResource::collection($product),
                'pagination'=>[
                    'current_page'=>$product->currentPage(),
                    'total_pages'=>$product->lastPage(),
                    'per_page'=>$product->perPage(),
                    'total_items'=>$product->total()
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => true,
                'message' => 'Record Fetched! '.$th->getMessage()
            ]);
        }
    }

    public function getCategory()
    {
        try {
            $categories = $this->productService->getAllCategory();
            return response()->json([
                'status' => true,
                'message' => 'Categories fetched!',
                'data' => $categories
            ]);
        } catch (\Throwable $e) {
            Log::info("Error fetching categories: " . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch categories!',
                'data' => []
            ]);
        }
    }
}
