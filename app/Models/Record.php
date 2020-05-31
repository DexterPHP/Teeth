<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $table='records';
    protected $fillable=['id','patient_id','doctor_id','set_total','set_payment','teeth_lab','set_note','teeth_work_name','working_teeth','uuid'];
    public function Patient_data(){
        return $this->belongsTo('App\Models\Patients','id');
    }
    public function Doctor_data(){
        return $this->hasOne('App\Models\Doctor','id');
    }
    public function Lab_data(){
        return $this->hasOne('App\Models\Labs','id');
    }


}
