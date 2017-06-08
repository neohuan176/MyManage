<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['*'];
    //一个产品对应多个图片
    public function images()
    {
        return $this->hasMany('App\ProductImage','productId');
    }
}
