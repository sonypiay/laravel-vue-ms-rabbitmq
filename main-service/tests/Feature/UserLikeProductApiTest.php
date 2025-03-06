<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserLikeProductApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_user_like_product_api(): void
    {
        $response = $this->get('/api/user');

        $response->assertStatus(200);
    }
}
