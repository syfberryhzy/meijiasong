<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIntegralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('integrals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('order_id')->unsigned();
            $table->foreign('order_id')->references('id')->on('orders');
            $table->tinyInteger('type')->comment('积分增减 1=+,2=-')->default(1);
            $table->decimal('number', 10, 2)->comment('积分数值')->default(1.00);
            $table->decimal('before', 10, 2)->comment('之前积分')->default(0.00);
            $table->decimal('current', 10, 2)->comment('当前积分')->default(1.00);
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
        Schema::dropIfExists('integrals');
    }
}
