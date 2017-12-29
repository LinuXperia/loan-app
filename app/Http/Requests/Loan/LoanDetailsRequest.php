<?php

namespace App\Http\Requests\Loan;

use Illuminate\Foundation\Http\FormRequest;

class LoanDetailsRequest extends FormRequest
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
            'amount'  => 'required|integer|min:1000',
            'rate'  => 'required|integer|min:1|max:100',
            'type'  => 'required',
            'duration'  => 'required|between:1,3',
            'payment_date'  => 'required|date',
            'processing_fee'  => 'required',
            'legal_fee'  => 'required',
            'car_track'  => 'required',
            'car_track_maintenance'  => 'required',
            'kra_search'  => 'required',
            'logistics'  => 'required',
            'mv'  => 'required',
            'discharge_fee'  => 'required',
            'remarks'  => 'required',
        ];
    }
}
