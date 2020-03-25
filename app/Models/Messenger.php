<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Messenger extends Model
{
    protected $table='masseges';
    public $fillable=['from_user','to_user','message_content'];
}
