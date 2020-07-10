<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class Patients extends Model
{
    protected static function boot(){
        parent::boot();
        static::addGlobalScope('active', function( Builder $builder){
            $builder->where('active',true);
        });
    }
    /*protected static function boot(){
        parent::boot();
        static::addGlobalScope('active',function( Builder $builder){
            $builder->where('active',1);
        });
    }*/
    protected $table='patients';
    protected $primaryKey="id";
    protected $fillable=[
        'id','username','lastname','birthday','user_age','user_login','gender','user_mobile', 'user_middel','active','diseases',
        'shoug','depress','smoking', 'notes','medical_notes','doctors_id','user_image','card_number','uuid','patient_box'
    ];

    public function MainDoctor(){
        return $this->belongsTo(Doctor::class,'doctors_id');
    }
    public function Records(){
        return $this->hasMany('App\Models\Record','patient_id');
    }

}
