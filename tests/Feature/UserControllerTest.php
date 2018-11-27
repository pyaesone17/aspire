<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that user should created successfully.
     */
    public function test_user_should_created_successfully()
    {
        $response = $this->json('POST', '/api/user', [
            'name' => 'Ve',
            'password' => '123456',
            'email' => 've@aspire.com',
        ]);

        $response->assertStatus(201);
    }
}
