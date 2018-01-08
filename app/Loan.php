<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
     * total customer loan borrowed
     * @param $query
     * @param $id
     * @return
     */
    public function scopeTotalLoan($query, $id){

        return $query->where([['user_id','=', $id],['approved', '=', true]])
            ->sum('amount_borrowed');
    }

    /**
     * total customer loan interest
     * @param $query
     * @param $id
     * @return
     */
    public function scopeTotalInterest($query, $id){

        $totalBorrowed = $query->where([['user_id','=', $id],['approved', '=', true]])->sum('amount_borrowed');
        $totalToPay = $query->where([['user_id','=', $id],['approved', '=', true]])->sum('amount_to_pay');

        return $totalToPay - $totalBorrowed;
    }

    public function scopeLoanBalance($query, $id, $total_loan){

        $totalPayed = DB::table('payments')->where([['loan_id','=', $id],['approved', '=', true]])->sum('amount');

        return $total_loan - $totalPayed ;


    }

    /**
     *get total daily loan
     * @param $query
     * @return
     */
    public function scopeDailyLoan($query){

        return $query->where([['approved', '=', true ], ['created_at', '>=', Carbon::today()]])->sum('amount_borrowed');
    }

    /**
     *get total daily approved loan
     * @param $query
     * @return
     */
    public function scopeDailyApprovedLoans($query){

        return $query->where([['approved', '=', true ], ['created_at', '>=', Carbon::today()]])->count();
    }

    /**
     * total un approved loans
     * @param $query
     * @return mixed
     */
    public function scopeUnapprovedLoans($query){

        return $query->where('approved', null)->count();
    }

    /**
     * daily Amount by Agent
     * @param $query
     * @param $id
     */
    public function scopeDailyAmountByAgent($query, $id){
        return $query->where([['agent' ,'=', $id], ['approved','=', true], ['created_at', '>=', Carbon::today()]])->sum('amount_borrowed');
    }

    /**
     * daily Amount count by Agent
     * @param $query
     * @param $id
     */
    public function scopeDailyAmountCountByAgent($query, $id){

        return $query->where([['agent' ,'=', $id], ['approved','=', true], ['created_at', '>=', Carbon::today()]])->count();
    }
}
