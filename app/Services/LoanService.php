<?php

namespace App\Services;

use Carbon\Carbon;
use App\Exceptions\RepaymentException;
use App\Exceptions\LoanException;
use App\Repository\Contracts\LoanRepositoryContract;
use App\Repository\Contracts\UserRepositoryContract;

class LoanService
{
    public $userRepository;

    public $loanRepository;

    public function __construct(LoanRepositoryContract $loanRepository, UserRepositoryContract $userRepository)
    {
        $this->loanRepository = $loanRepository;
        $this->userRepository = $userRepository;
    }

    public function takeLoan($userId, $amount, $duration, $interestRate, $arrangementFee, $repaymentFrequency)
    {
        if ($this->userRepository->find($userId) === null) {
            throw new LoanException('Invalid User', 0);
        }

        $totalAmount = $this->calculateTotal(
            $amount,
            $interestRate,
            $repaymentFrequency,
            $arrangementFee
        );

        $loan = $this->loanRepository->create(
            $userId,
            $amount,
            $duration,
            $interestRate,
            $arrangementFee,
            $repaymentFrequency,
            $totalAmount
        );

        return $loan;
    }

    public function repayLoan($userId, $loanId, $amount)
    {
        $loan = $this->loanRepository->find($loanId);

        if ($loan === null) {
            throw new RepaymentException('Invalid loan', 0);
        }

        $dueDate = $loan->created_at->addMonths($loan->duration);
        $now = Carbon::now();

        if ($now->gt($dueDate)) {
            throw new RepaymentException('Loan is already due, you can not pay anymore', 1);
        }

        if ($loan->isFullyPaid()) {
            throw new RepaymentException('Loan is already paid', 2);
        }

        if ($this->userRepository->find($userId) === null) {
            throw new RepaymentException('Invalid User', 3);
        }

        $shouldPay = round($this->shouldPay($loan->total_amount, $loan->repayment_frequency), 2);
        $$amount = round($amount, 2);

        if (abs($shouldPay - $amount) > 0.01) {
            throw new RepaymentException(
                sprintf('Amount mismatch, should pay %d but received %d', $shouldPay, $amount), 4
            );
        }

        $loan = $this->loanRepository->createRepay($userId, $loanId, $amount);

        return $loan;
    }

    protected function calculateTotal($amount, $interestRate, $repaymentFrequency, $arrangementFee)
    {
        $interestFee = $amount * ($interestRate / 100);

        return $amount + $arrangementFee + ($repaymentFrequency * $interestFee);
    }

    protected function shouldPay($totalAmount, $repaymentFrequency)
    {
        return $totalAmount / $repaymentFrequency;
    }
}
