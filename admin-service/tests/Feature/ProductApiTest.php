<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Log;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    /**
     * Get all products
     */
    public function test_get_all_products(): void
    {
        $response = $this
            ->withHeaders([
                'X-Requested-With', 'XMLHttpRequest'
            ])
            ->getJson('/api/products');

        $response->assertOk();
        $response->assertJsonIsArray();
    }

    /**
     * Get product by id
     */
    public function test_get_product_by_id(): void
    {
        $createResponse = $this->postJson("/api/products", [
            "title" => "Samsung",
            "image" => "samsung"
        ]);

        $createResponse->assertCreated();
        $createResponse->assertJson(['title' => 'Samsung']);

        $productId = $createResponse['id'];

        $response = $this
            ->withHeaders([
                'X-Requested-With', 'XMLHttpRequest'
            ])
            ->getJson('/api/products/' . $productId);

        $response->assertOk();
        $response->assertJson([
            'title' => 'Samsung',
        ]);
    }

    /**
     * If get product by id is not found
     */
    public function test_not_found_get_product_by_id(): void
    {
        $response = $this
            ->withHeaders([
                'X-Requested-With', 'XMLHttpRequest'
            ])
            ->getJson('/api/products/salah');

        $response->assertNotFound();
    }

    /**
    * Create new product
    */
    public function test_create_new_product(): void
    {
        $createResponse = $this->postJson("/api/products", [
            "title" => "Samsung",
            "image" => "samsung"
        ]);

        $createResponse->assertCreated();
        $createResponse->assertJson(['title' => 'Samsung']);

        $productId = $createResponse['id'];
        $deleteResponse = $this->deleteJson("/api/products/{$productId}");
        $deleteResponse->assertOk();
        $deleteResponse->assertJson([
            'message' => 'Product successfully deleted'
        ]);
    }

    /**
     * Update product by id
     */
    public function test_update_product_by_id(): void
    {
        $createResponse = $this->postJson("/api/products", [
            "title" => "Samsung",
            "image" => "samsung"
        ]);

        $createResponse->assertCreated();
        $createResponse->assertJson(['title' => 'Samsung']);

        $productId = $createResponse['id'];
        $updateResponse = $this->patchJson("/api/products/{$productId}", [
            'title' => "Apple",
            "image" => "apple",
        ]);

        $updateResponse->assertAccepted();
        $updateResponse->assertJson([
            'title' => 'Apple',
            'image' => 'apple'
        ]);

        $deleteResponse = $this->deleteJson("/api/products/{$productId}");
        $deleteResponse->assertOk();
        $deleteResponse->assertJson(['message' => 'Product successfully deleted']);
    }

    /**
     * Delete product by id
     */
    public function test_delete_product_by_id(): void
    {
        $createResponse = $this->postJson("/api/products", [
            "title" => "Samsung",
            "image" => "samsung"
        ]);

        $createResponse->assertCreated();
        $createResponse->assertJson(['title' => 'Samsung']);

        $productId = $createResponse['id'];
        $deleteResponse = $this->deleteJson("/api/products/{$productId}");
        $deleteResponse->assertOk();
        $deleteResponse->assertJson(['message' => 'Product successfully deleted']);
    }
}
