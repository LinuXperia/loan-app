<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgentDetails extends Model
{
    protected $fillable = ['phone','address','country','description'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
