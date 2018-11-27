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
            'duration' => 6,
            'interest_rate' => 1.5,
            'arrangement_fee' => 0,
            'repayment_frequency' => 6,
            'amount' => 10000,
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'data' => [
                'total_amount' => 10900,
            ],
        ]);

        $loanId = $response->json()['data']['id'];

        $response = $this->json('PUT', '/api/loan/'.$loanId.'/repay', [
            'user_id' => $user->id,
            'amount' => 1816.67,
        ]);

        $response->assertStatus(200);
    }

    /**
     * Test that repayment should failed when wrong amount pay.
     */
    public function test_repayment_should_failed_when_wrong_amount_pay()
    {
        $user = factory(User::class)->create();

        $response = $this->json('POST', '/api/loan', [
            'user_id' => $user->id,
            'duration' => 6,
            'interest_rate' => 1.5,
            'arrangement_fee' => 0,
            'repayment_frequency' => 6,
            'amount' => 10000,
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'data' => [
                'total_amount' => 10900,
            ],
        ]);

        $loanId = $response->json()['data']['id'];

        $response = $this->json('PUT', '/api/loan/'.$loanId.'/repay', [
            'user_id' => $user->id,
            'amount' => 1000,
        ]);

        $response->assertStatus(400);
    }
}
