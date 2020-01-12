<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //Temp Delete

class Work extends Model
{
use SoftDeletes; //use Temp Delete
protected $dates = ['deleted_at']; //Temp Delete created date and time

//It is used to create mass assign
protected $fillable = [
 'name', 'design', 'is_admin'
];

public function user(){
  return $this->belongsTo('App\User');
}

}
