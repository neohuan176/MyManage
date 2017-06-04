<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdinaryRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordinary_records', function (Blueprint $table) {
            $table->increments('id');
            $table->string('product')->nullable();//产品名称
            $table->string('unit')->nullable();//单位
            $table->string('size')->nullable();//规格
            $table->string('unitPrice')->nullable();//单价
            $table->integer('count')->nullable();//购买数量
            $table->float('totalPrice')->nullable();//总价格
            $table->string('describe')->nullable();//记录备注
            $table->unsignedInteger('orderId');//记录备注
            $table->foreign('orderId')->references('id')->on('ordinary_orders')->onDelete('cascade');
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
        Schema::dropIfExists('ordinary_records');
    }
}
