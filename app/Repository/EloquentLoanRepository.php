<?php 

namespace App\Repository;

use App\Loan;
use App\Repository\Contracts\LoanRepositoryContract;

class EloquentLoanRepository implements LoanRepositoryContract
{
    public $loan;

    public function __construct(Loan $loan) 
    {
        $this->loan = $loan;
    }

    public function find($id)
    {
        return $this->loan->newQuery()->with('repayments')->find($id);
    }

    public function create($userId, $amount, $duration, $interestRate, $arrangementFee, $repaymentFrequency, $totalAmount)
    {
        return $this->loan->create([
            'amount' => $amount,
            'user_id' => $userId,
            'duration' => $duration, 
            'repayment_frequency' => $repaymentFrequency, 
            'interest_rate' => $interestRate, 
            'arrangement_fee' => $arrangementFee,
            'total_amount' => $totalAmount,
        ]);
    }

    public function createRepay($userId, $loanId, $amount)
    {
        $loan = $this->loan->newQuery()->findOrFail($loanId);

        $loan->repayments()->create([
            'amount' => $amount, 
            'user_id' => $userId
        ]);

        $loan->load('repayments');

        return $loan;
    }
}
