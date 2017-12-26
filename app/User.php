<?php

namespace App;

use App\Http\Requests\Borrower\PersonalDetails;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use Notifiable, EntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','registered_by',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function borrowerPersonalDetails(){

        return $this->hasOne(BorrowerPersonalDetails::class);
    }

    public function borrowerNextOfKin(){

        return $this->hasOne(BorrowerNextOfKin::class);
    }

    public function borrowerBankDetails(){

        return $this->hasMany(BorrowerBankDetails::class);
    }

    public function borrowerResidenceDetails(){
        return $this->hasOne(BorrowerResidenceDetails::class);
    }

    public function borrowerWorkDetails(){
        return $this->hasOne(BorrowerWorkDetails::class);
    }

    public function refereesDetails(){
        return $this->hasMany(RefereesDetails::class);
    }
}
