<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    // public function test_example(): void
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(201);
    // }

    public function test_create_product()
    {
        $response = $this->postJson('/api/products', [
            'sku' => 'TEST-001',
            'name' => 'Test Product',
            'price' => 100,
            'stock_quantity' => 10,
            'low_stock_threshold' => 5,
            'status' => 'active',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'success',
                'data'
            ]);

        $this->assertDatabaseHas('products', [
            'sku' => 'TEST-001'
        ]);
    }

    public function test_get_products_list()
    {
        Product::factory()->count(3)->create();

        $response = $this->getJson('/api/products');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data',
                'meta'
            ]);
    }

    public function test_get_single_product()
    {
        $product = Product::factory()->create();

        $response = $this->getJson("/api/products/{$product->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data'
            ]);
    }

    public function test_update_product()
    {
        $product = Product::factory()->create();

        $response = $this->putJson("/api/products/{$product->id}", [
            'name' => 'Updated Name',
            'sku' => $product->sku,
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Name'
        ]);
    }

    public function test_increment_stock()
    {
        $product = Product::factory()->create([
            'stock_quantity' => 10
        ]);

        $response = $this->postJson("/api/products/{$product->id}/stock", [
            'type' => 'increment',
            'quantity' => 5
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock_quantity' => 15
        ]);
    }

}
