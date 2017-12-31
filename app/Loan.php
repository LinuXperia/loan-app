<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use PhpParser\Builder;

class Loan extends Model
{
    protected $fillable = ['reference_no','agent','loan_type','amount_borrowed','amount_to_pay','duration','interest_rate','processing_fee','car_track_installation','car_track_maintenance','kra','legal_fee','logistics','mv','discharge_fee','description','approved','status','approved_date','payment_date'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function payments(){
        return $this->hasMany(Payment::class);
    }

    /**
     * total borrower loan borrowed
     * @param $query
     * @param $id
     * @return
     */
    public function scopeTotalLoan($query, $id){

        return $query->where('user_id', $id)
            ->sum('amount_borrowed');
    }

    /**
     * total borrower loan interest
     * @param $query
     * @param $id
     * @return
     */
    public function scopeTotalInterest($query, $id){

        $totalBorrowed = $query->where('user_id', $id)->sum('amount_borrowed');
        $totalToPay = $query->where('user_id', $id)->sum('amount_to_pay');

        return $totalToPay - $totalBorrowed;
    }
}
