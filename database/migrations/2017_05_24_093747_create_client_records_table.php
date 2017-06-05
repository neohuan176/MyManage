<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_records', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('clientId');//顾客id
            $table->string('product')->nullable();//产品名称
            $table->string('unit')->nullable();//单位
            $table->string('unitPrice')->nullable();//单位
            $table->integer('count')->nullable();//购买数量
            $table->float('totalPrice')->nullable();//总价格
            $table->dateTime('time')->nullable();//购买时间
            $table->string('describe')->nullable();//订单备注
            $table->string('_number')->nullable();//订单流水号
            $table->string('size')->nullable();//规格
            $table->boolean('isDone')->default(false);//完成状态
            $table->foreign('clientId')->references('id')->on('clients')->onDelete('cascade');
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
        Schema::dropIfExists('client_records');
    }
}
