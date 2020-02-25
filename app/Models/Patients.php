<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Patients extends Model
{
    protected $table='patients';
    protected $primaryKey="id";
    protected $fillable=[
        'id','username','lastname','birthday','user_age','user_login','gender','user_mobile', 'user_middel',
        'shoug','depress','smoking', 'notes','medical_notes','doctors_id','user_image','card_number','uuid'
    ];

    public function MainDoctor(){
        return $this->belongsTo(Doctor::class,'doctors_id');
    }

}
