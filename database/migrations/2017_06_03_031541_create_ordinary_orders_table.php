<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdinaryOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordinary_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('adminId')->default(0);//管理员id
            $table->string('orderInfo')->nullable();//订单详述
            $table->string('_number')->nullable();//订单编号
            $table->string('totalPrice')->nullable();//总金额
            $table->dateTime('time')->nullable();//购买时间
            $table->string('describe')->nullable();//订单备注
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ordinary_orders');
    }
}
