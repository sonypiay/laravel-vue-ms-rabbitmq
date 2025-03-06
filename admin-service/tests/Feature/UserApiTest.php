<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_get_user(): void
    {
        $response = $this->get('/api/user');
        $response->assertOk();
        $response->assertJson(['id' => true ]);
    }
}
