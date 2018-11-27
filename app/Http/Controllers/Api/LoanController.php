<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\LoanService;
use App\Http\Requests\LoanRequest;
use App\Http\Resources\Loan as LoanResource;

class LoanController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(LoanService $loanService, LoanRequest $request)
    {
        $loan = $loanService->takeLoan(
            $request->user_id,
            $request->amount,
            $request->duration,
            $request->interest_rate,
            $request->arrangement_fee,
            $request->repayment_frequency
        );

        return (new LoanResource($loan))->additional([ 'success' => true ]);
    }
}
