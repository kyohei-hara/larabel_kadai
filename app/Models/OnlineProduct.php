<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DateTime;

class OnlineProduct extends Model
{
    use Notifiable;
    protected $primaryKey = 'PRODUCT_CODE';
    protected $table = 'online_product';
    public $timestamps = false;
    public $incrementing = false;

    public function reduce($code, $quantity){
        $connect = new OnlineProduct();
        $product = $connect->where('PRODUCT_CODE',$code)->first();
        $product->STOCK_COUNT = $product->STOCK_COUNT - $quantity;
        $product->LAST_UPD_DATE = new DateTime();
        $product->save();
    }
    protected $fillable = [
        'PRODUCT_CODE', 'CATEGORY_ID' ,'PRODUCT_NAME', 'MAKER', 'STOCK_COUNT', 'REGISTER_DATE', 'UNIT_PRICE', 'PICTURE_NAME', 'MEMO', 'DELETE_FLG' , "LAST_UPD_DATE"
    ];

    protected $hidden = [
       'PASSWORD',
   ];
}