<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'duration', 'interest_rate',
        'arrangement_fee', 'repayment_frequency', 'amount'
    ];

    public function repayments()
    {
        return $this->hasMany(Repayment::class);
    }

    public function repay($attributes)
    {
        $this->repayments()->create($attributes);
    }
}
