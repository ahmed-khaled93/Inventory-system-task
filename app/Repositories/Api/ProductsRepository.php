<?php

namespace App\Repositories\Api;

use App\Repositories\BaseRepository;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Events\LowStockDetected;

/**
 * Class ProductsRepository.
 */
class ProductsRepository extends BaseRepository
{
    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function find(string $id)
    {
        return Product::findOrFail($id);
    }

    public function create(array $data)
    {
        return Product::create($data);

        Cache::flush();
    }

    public function update($product, array $data)
    {
        $product->update($data);

        Cache::flush();

        return $product;
    }

    public function delete($product)
    {
        $product->delete();

        Cache::flush();
    }

    public function lowStock()
    {
        return Product::whereColumn('stock_quantity', '<=', 'low_stock_threshold')->get();
    }

    public function adjustStock($product, string $type, int $quantity)
    {
        DB::transaction(function () use ($product, $type, $quantity) {

            $product = Product::where('id', $product->id)->first();

            if ($type === 'increment') {
                $product->increment('stock_quantity', $quantity);
            }

            if ($type === 'decrement') {
                if ($product->stock_quantity < $quantity) {
                    throw new \Exception('Insufficient stock');
                }

                $product->decrement('stock_quantity', $quantity);
            }

            $product->refresh();

            // Fire Low Stock Event
            if ($product->stock_quantity <= $product->low_stock_threshold) {
                event(new LowStockDetected($product)); 
            }

            Cache::flush();

            });

        return $product->fresh();
    }

}
