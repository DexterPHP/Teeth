<?php

namespace App\Models;

use http\Client\Curl\User;
use Illuminate\Database\Eloquent\Model;

class Rols extends Model
{
    protected $table = "roles";
    public $fillable = ['name','uuid','permissions'];
    public function users(){
        return $this->belongsToMany(User::class,'role_users','rols_id');
    }

    public function hasAccess(array $permissions){
        foreach ($permissions as $permission){
            if($this->hasPermission($permission)){
                return true;
            }
            return false;

        }


    }

    protected function hasPermission(string $parmission){
        $permissions =  \GuzzleHttp\json_decode($this->permissions,true);
        return $permissions[$parmission]??false;
    }
}
