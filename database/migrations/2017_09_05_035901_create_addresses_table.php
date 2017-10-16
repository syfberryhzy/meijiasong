<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('receiver', 20)->comment('收货人');
            $table->string('phone', 11)->comment('联系方式');
            $table->string('areas', 50)->comment('省市区');
            $table->string('details', 50)->comment('详细地址')->nullable();
            $table->string('longitude', 50)->comment('纬度');
            $table->string('latitude', 50)->comment('经度');
            $table->tinyInteger('is_default')->comment('是否默认1=默认，0=不默认')->default(0);
            $table->tinyInteger('status')->comment('状态1=默认，0=不默认')->default(0);
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
        Schema::dropIfExists('addresses');
    }
}
