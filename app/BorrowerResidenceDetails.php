<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BorrowerResidenceDetails extends Model
{
    protected $fillable = ['address', 'stay', 'previous', 'house', 'permanent_address'];

    public function user(){

        return $this->belongsTo(User::class);
    }
}
