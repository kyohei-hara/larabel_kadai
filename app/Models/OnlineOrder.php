<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DateTime;


class OnlineOrder extends Model
{
    //
    protected $table = 'online_order';
    protected $primaryKey = 'ORDER_NO';

    public $timestamps = false;
    public $incrementing = false;

    public function getId(){
        $result = OnlineOrder::get('COLLECT_NO')->sortByDesc('COLLECT_NO')->first();
        return $result != null ? $result->COLLECT_NO + 1 : 1;
    }
    public function add ($id, $subtotal, $tax, $no){
        $order =  new OnlineOrder();
        $order->MEMBER_NO = $id;
        $order->TOTAL_MONEY = $subtotal;
        $order->TOTAL_TAX = $tax;
        $order->ORDER_DATE = new DateTime();
        $order->COLLECT_NO = $no;
        $order->LAST_UPD_DATE = new DateTime();
        $order->save();
    }
    protected $fillable = ['ORDER_NO','COLLECT_NO'];
}