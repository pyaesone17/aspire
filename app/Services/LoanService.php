<?php 

namespace App\Services;

use Exception;
use App\Repository\LoanRepository;
use App\Repository\UserRepository;

class LoanService
{
    public $userRepository;
    
    public $loanRepository;

    public function __construct(LoanRepository $loanRepository, UserRepository $userRepository)
    {
        $this->loanRepository = $loanRepository;
        $this->userRepository = $userRepository;
    }

    public function takeLoan($userId, ...$data)
    {
        if ($this->userRepository->find($userId)===null) {
            throw new Exception("Invalid User");
        }
 
        $loan = $this->loanRepository->create(...array_merge([$userId], $data));

        return $loan;
    }

    public function repayLoan($userId, $loanId, $amount)
    {
        $loan = $this->loanRepository->find($loanId);

        if ($loan === null) {
            throw new Exception("Invalid loan");
        }

        if ($this->isFullyPaid($loanId)) {
            throw new Exception("Loan is already paid");
        }

        if ($this->userRepository->find($userId)===null) {
            throw new Exception("Invalid User");
        }

        $loan = $this->loanRepository->createRepay($userId, $loanId, $amount);

        return $loan;
    }

    protected function isFullyPaid($loan)
    {   
        if ($loan->repayment_frequency===$loan->repayments->count()) {
            return true;
        }
    }

    protected function totalNet($loan)
    {
        $totalAmount = $loan->amount;
        $interestFees = $loan->amount * ( $loan->interest_fee / 100 );

        return $totalAmount + ($loan->repayment_frequency * $interestFees) + $loan->arrangement_fee;
    }
}
