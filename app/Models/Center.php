<?php

namespace App\Models;

use App\Models\Doctor;
use Illuminate\Database\Eloquent\Model;

class Center extends Model
{
    protected $table ='centers';
    //public $timestamps=false;
    protected $fillable=[
        'id','center_name','decr_h','center_id','uuid'
    ];
    public function Accounter(){
        return $this->belongsTo('App\Models\Accounter','center_id');
    }
    public function Doctors(){
        return $this->belongsTo('App\Models\Doctor','center_id');
    }
    public function Diseases(){
        return $this->hasMany('App\Models\Diseases','center_id');

    }
}
