<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class OnlineProduct extends Model
{
    use Notifiable;
    protected $primaryKey = 'PRODUCT_CODE';
    protected $table = 'online_product';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
        'PRODUCT_CODE', 'CATEGORY_ID' ,'PRODUCT_NAME', 'MAKER', 'STOCK_COUNT', 'REGISTER_DATE', 'UNIT_PRICE', 'PICTURE_NAME', 'MEMO', 'DELETE_FLG'
    ];

    protected $hidden = [
       'PASSWORD',
   ];
}
