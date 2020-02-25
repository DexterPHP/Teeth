<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dates extends Model
{
   protected $table='dates';
   public $fillable=['id','title','what_date','start_time','left_time','doctor_id','patients_id','priority','uuid'];
   public function Doctors(){
       return $this->hasOne('App\Models\Doctor','id');
   }
   public function Patients(){
       return $this->hasMany('App\Models\Patients','patients_id');
   }
}
