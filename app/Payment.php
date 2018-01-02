<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['reference_no', 'agent','amount','payment_mode','cheque_no','mpesa_no','slug','approved','description'];

    public function loan(){

        return $this->belongsTo(Loan::class);
    }

    /**
     * @param $query
     * @param $id
     * @param $total_loan
     * @return mixed
     */
    public function scopeLoanBalance($query, $id, $total_loan){

        $totalPayed = $query->where('loan_id', $id)->sum('amount');

        return $total_loan - $totalPayed ;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function scopeTotalPayment($query, $id){

        $user = User::findOrFail($id);

        return $user->payments()->sum('amount');

    }
}
