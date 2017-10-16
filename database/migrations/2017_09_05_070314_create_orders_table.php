<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('pay_id')->unsigned();
            $table->foreign('pay_id')->references('id')->on('pays');
            $table->timestamp('send_time')->comment('送货时间');
            $table->decimal('amount', 10, 2)->comment('总计')->default('0.00');
            $table->decimal('discount', 10, 2)->comment('折扣')->default('0.00');
            $table->decimal('total', 10, 2)->comment('实际付款')->default('0.00');
            $table->tinyInteger('is_discount')->comment('是否折扣0/1')->default(0);
            $table->tinyInteger('status')->comment('订单状态：1=待付款,2=已付款,3=已取消,4=已完成')->default('1');
            $table->string('order_no')->comment('订单号');
            $table->string('out_trade_no')->comment('付款编号')->nullable();
            $table->string('receiver')->comment('收货人')->nullable();
            $table->string('phone', 11)->comment('电话')->nullable();
            $table->string('address', 50)->comment('送货地址')->nullable();
            $table->string('remarks', 50)->comment('备注')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
