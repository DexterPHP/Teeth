<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $table='doctors';
    protected $fillable=[
        'id','doctor_fname','doctor_username','doctor_pass','doctor_spicalest',
        'doctor_mobile','doctoe_accounter','center_id','uuid','user_id',
        'Type','cash_percent','moneybox'
    ];
    public function Centers(){
        return $this->hasOne('App\Models\Center','id');
        // Center_id [FK] for colmoun (Center_id) in Doctor Table
    }
    public function Patiens(){
        return $this->hasMany('App\Models\Patients','doctors_id');
    }
    public function Dates(){
        return $this->hasMany('App\Models\Dates','doctor_id');
    }

}
