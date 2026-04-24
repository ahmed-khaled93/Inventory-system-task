<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Repositories\Api\ProductsRepository;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\AdjustStockRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Cache;


class ProductController extends Controller
{

    protected $productsRepository;

	public function __construct(ProductsRepository $productsRepository)
    {
        $this->productsRepository = $productsRepository;
    }


    public function index()
    {
        $page = request('page', 1);

        $products = Cache::remember(
            "products_page_$page", 60, // seconds
            function () {
                return Product::orderBy('id', 'desc')->paginate(10);
            }
        );

        return response()->json([
            'success' => true,
            'data' => ProductResource::collection($products),
            'meta' => [
                'pagination' => [
                    'current_page' => $products->currentPage(),
                    'last_page' => $products->lastPage(),
                    'total' => $products->total(),
                ]
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $product = $this->productsRepository->create(
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'data' => new ProductResource($product)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return response()->json([
            'success' => true,
            'data' => new ProductResource($product)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $updated = $this->productsRepository->update(
            $product,
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'data' => new ProductResource($updated)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->productsRepository->delete($product);

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully'
        ]);
    }

    public function lowStock()
    {
        $products = $this->productsRepository->lowStock();

        return response()->json([
            'success' => true,
            'data' => ProductResource::collection($products)
        ]);
    }


    public function adjustStock(AdjustStockRequest $request, Product $product)
    {   
        
        try {
            $updated = $this->productsRepository->adjustStock(
                $product,
                $request->type,
                $request->quantity
            );

            return response()->json([
                'success' => true,
                'data' => new ProductResource($updated)
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }

    }
    
}
