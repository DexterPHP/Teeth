<?php

namespace App;

use App\Models\Rols;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','uuid','center_id','user_type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles(){
        return $this->belongsToMany(Rols::class,'role_users','user_id');
    }
    public function Center(){
        return $this->belongsTo('App/Models/Center','center_id');
    }

    public function hasAccess(array $permissions){
        foreach ($this->roles as $role){
            if($role->hasAccess($permissions)){
                return true;
            }
            return false;
        }
    }
}
