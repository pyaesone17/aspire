<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RepaymentControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that repayment should successfully created.
     */
    public function test_repayment_should_successfully_created()
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

        $loanId = $response->json()['data']['id'];

        $response = $this->json('PUT', '/api/loan/'.$loanId.'/repay', [
            'user_id' => $user->id,
            'amount' => 1510,
        ]);

        $response->assertStatus(200);
    }
}
