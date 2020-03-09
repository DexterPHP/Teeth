<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transitions extends Model
{
    protected $table='transitions';
    public $fillable=['id','Amount','Type','center_id','user_id','Opeartion'];

    public function TransData(){
        //return $this->belongsTo();
    }
}
