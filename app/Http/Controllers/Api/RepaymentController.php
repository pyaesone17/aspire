<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\LoanService;
use App\Http\Controllers\Controller;
use App\Http\Requests\RepaymentRequest;
use App\Http\Resources\Loan as LoanResource;

class RepaymentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(LoanService $loanService, RepaymentRequest $request, $loanId)
    {
        $loan = $loanService->repayLoan(
            $request->user_id,
            $loanId,
            $request->amount
        );

        return (new LoanResource($loan))->additional([ 'success' => true ]);
    }
}
