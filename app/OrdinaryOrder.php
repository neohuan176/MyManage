<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdinaryOrder extends Model
{
    protected $fillable = ['*'];
    //一个普通订单对应多个记录
    public function records()
    {
        return $this->hasMany('App\OrdinaryRecord','orderId');
    }
}
