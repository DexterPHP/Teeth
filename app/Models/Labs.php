<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Labs extends Model
{
    protected $table='labs';
    protected $fillable =['id','lab_name','lab_spi','lab_phone','lab_location','uuid'];
    public function Record_data(){
        return $this->hasMany('App\Models\Record','records_id');
    }
}
