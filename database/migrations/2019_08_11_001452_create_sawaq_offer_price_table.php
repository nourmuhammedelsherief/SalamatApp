<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSawaqOfferPriceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sawaq_offer_price', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sawaq_user_id')->unsigned()->index();
            $table->foreign('sawaq_user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

            $table->bigInteger('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('sawaq_users')->onDelete('cascade')->onUpdate('cascade');

            $table->bigInteger('order_id')->unsigned()->index();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade')->onUpdate('cascade');
            $table->double('price');
            $table->tinyInteger('status');
            $table->double('commission');
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
        Schema::dropIfExists('sawaq_offer_price');
    }
}
