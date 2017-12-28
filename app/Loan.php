<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $fillable = ['agent','loan_type','amount_borrowed','amount_to_pay','duration','interest_rate','processing_fee','car_track_installation','car_track_maintenance','kra','legal_fee','logistics','mv','discharge_fee','description','approved','status','approved_date','payment_date'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
