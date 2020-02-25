<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accounter extends Model
{
    protected $table='accounters';
    protected $fillable=['id','accounter_fname','accounter_login','accounter_pass','accounter_phone','center_id','uuid'];
    // Accounter Has only one Center
    public function Center(){
        return $this->hasOne('App\Models\Center','center_id');
    }

}
