<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BorrowerPersonalDetails extends Model
{
   protected $fillable = [
       'title','fname','lname','sname','nationality','idNumber','pin','mobile','telephone','dob','address','office','home','marital','education'
   ];

   public function user(){

       return $this->belongsTo(User::class);
   }
}
