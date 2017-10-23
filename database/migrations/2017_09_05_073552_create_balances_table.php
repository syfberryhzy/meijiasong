<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balances', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            // $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedInteger('order_id');
            // $table->foreign('order_id')->references('id')->on('orders');
            $table->tinyInteger('type')->comment('余额增减 1=+,2=-')->default(1);
            $table->decimal('number', 10, 2)->comment('余额数值')->default(1.00);
            $table->decimal('before', 10, 2)->comment('之前余额')->default(0.00);
            $table->decimal('current', 10, 2)->comment('当前余额')->default(1.00);
            $table->string('desc', 50)->comment('备注');
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
        Schema::dropIfExists('balances');
    }
}
