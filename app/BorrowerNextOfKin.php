<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BorrowerNextOfKin extends Model
{
    protected $fillable = [ 'name', 'relationship', 'phone', 'email', 'address'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
