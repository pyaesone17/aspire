<?php 

namespace App\Repository;
use App\Loan;

class LoanRepository
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

    public function create($userId, $amount, $duration, $repaymentFrequency, $interestRate, $arrangementFee)
    {
        return $this->loan->create([
            'amount' => $amount,
            'user_id' => $userId,
            'duration' => $duration, 
            'repayment_frequency' => $repaymentFrequency, 
            'interest_rate' => $interestRate, 
            'arrangement_fee' => $arrangementFee
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
