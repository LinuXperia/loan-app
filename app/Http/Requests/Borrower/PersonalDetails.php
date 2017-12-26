<?php

namespace App\Http\Requests\Borrower;

use Illuminate\Foundation\Http\FormRequest;

class PersonalDetails extends FormRequest
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
            'title' => 'required',
            'fname' => 'required',
            'sname' => 'required',
            'lname' => '',
            'nationality' => 'required',
            'idNumber' => 'required|numeric',
            'pin' => 'required',
            'email' => 'required|email',
            'mobile' => 'required|numeric',
            'telephone' => '',
            'dob' => 'required|date',
            'address' => 'required',
            'office' => '',
            'home' => '',
            'marital' => 'required',
            'education' => 'required',
        ];
    }
}
