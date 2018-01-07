<?php

namespace App\Http\Requests\Loan;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed payment_id
 */
class LoanPaymentRequest extends FormRequest
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
            'amount'  => 'required|integer|min:500',
            'mode' => 'required',
            'mpesa' => 'required_if:mode,==,mpesa',
            'cheque' => 'required_if:mode,==,cheque',
            'description' =>'required'
        ];
    }
}
