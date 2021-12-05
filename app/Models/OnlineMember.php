<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class OnlineMember extends Authenticatable
{

    use Notifiable;

    protected $table = 'online_member';
    public $timestamps = false;

    protected $fillable = [
        'MEMBER_NO', 'NAME' ,'PASSWORD',
    ];

    protected $hidden = [
       'PASSWORD',
   ];

}
