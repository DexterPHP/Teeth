<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    protected $table = 'treatments';
    public $fillable = ['title','price','center_id'];

    public function CenterTreatment(){
        return $this->hasOne('App\Models\center','center_id');
    }
}
