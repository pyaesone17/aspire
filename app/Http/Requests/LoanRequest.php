<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required',
            'amount' => 'required',
            'duration' => 'required',
            'interest_rate' => 'required',
            'arrangement_fee' => 'required',
            'repayment_frequency' => 'required',
        ];
    }
}
