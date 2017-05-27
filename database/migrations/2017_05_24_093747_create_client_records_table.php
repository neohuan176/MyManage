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
            $table->integer('clientId');//顾客id
            $table->string('product');//产品名称
            $table->string('unit');//单位
            $table->string('unitPrice');//单位
            $table->integer('count');//购买数量
            $table->float('tootlePrice');//总价格
            $table->dateTime('time');//购买时间
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
