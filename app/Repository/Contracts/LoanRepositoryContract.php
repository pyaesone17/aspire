<?php 

namespace App\Repository\Contracts;

interface LoanRepositoryContract
{
    public function find($id);

    public function create($userId, $amount, $duration, $interestRate, $arrangementFee, $repaymentFrequency, $totalAmount);

    public function createRepay($userId, $loanId, $amount);
}
