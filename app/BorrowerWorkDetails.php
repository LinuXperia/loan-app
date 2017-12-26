<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BorrowerWorkDetails extends Model
{

    protected $fillable = ['employer','years', 'address', 'phone', 'occupation', 'tenure', 'previous_employer','employment_type','business_name','business_physical_address','business_gross','business_nature'];

    public function user(){

        return $this->belongsTo(User::class);
    }
}
