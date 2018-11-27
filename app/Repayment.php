<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Repayment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount', 'loan_id'
    ];
}
