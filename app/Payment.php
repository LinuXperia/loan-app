<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['reference_no', 'agent','amount','payment_mode','cheque_no','mpesa_no','slug','approved','description'];

    public function loan(){

        return $this->belongsTo(Loan::class);
    }
}
