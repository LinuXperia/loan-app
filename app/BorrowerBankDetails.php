<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BorrowerBankDetails extends Model
{
    protected $fillable = ['name', 'branch', 'facility', 'type', 'amount'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
