<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class OnlineMember extends Authenticatable
{

    use Notifiable;
    protected $primaryKey = 'MEMBER_NO';
    protected $table = 'online_member';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
        'MEMBER_NO', 'NAME' ,'PASSWORD', 'AGE', 'SEX', 'ADDRESS', 'TEL', 'ZIP', 'REGISTER_DATE', 'DELETE_FLG'
    ];

    protected $hidden = [
       'PASSWORD',
   ];

}