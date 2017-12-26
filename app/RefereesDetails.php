<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RefereesDetails extends Model
{
    protected $fillable = ['name','relationship','acquainted','nationality','home_phone','work_phone','mobile_phone','email','address'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}

