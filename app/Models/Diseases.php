<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diseases extends Model
{
    protected $table = 'diseases';
    protected $fillable = ['id','title','center_id'];

    public function Center(){
        return $this->belongsTo('App\Models\Center','id');
    }
}
