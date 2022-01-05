<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnlineOrderList extends Model
{
    protected $table = 'online_order_list';

    public $timestamps = false;
    public $incrementing = false;

    public function add ($no, $code, $quantity, $price){
        $orderList =  new OnlineOrderList();
        $orderList->COLLECT_NO = $no;
        $orderList->PRODUCT_CODE = $code;
        $orderList->ORDER_COUNT = $quantity;
        $orderList->ORDER_PRICE = $price;
        $orderList->save();
    }
}