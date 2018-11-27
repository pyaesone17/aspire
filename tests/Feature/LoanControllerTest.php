<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoanControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that loan should successfully created.
     */
    public function test_loan_should_successfully_created()
    {
        $user = factory(User::class)->create();

        $response = $this->json('POST', '/api/loan', [
            'user_id' => $user->id,
            'duration' => 10,
            'interest_rate' => 5,
            'arrangement_fee' => 100,
            'repayment_frequency' => 10,
            'amount' => 10000,
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'data' => [
                'total_amount' => 15100,
            ],
        ]);
    }
}
