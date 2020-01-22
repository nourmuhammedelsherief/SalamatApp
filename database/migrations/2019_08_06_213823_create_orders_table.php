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
            $table->bigIncrements('id');
            $table->tinyInteger('order_type');
            $table->bigInteger('from_city_id')->unsigned()->index()->nullable();
            $table->foreign('from_city_id')
                ->references('id')->on('cities')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->bigInteger('from_region_id')->unsigned()->index()->nullable();
            $table->foreign('from_region_id')
                ->references('id')->on('cities')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('to_region_id')->unsigned()->index()->nullable();
            $table->foreign('to_region_id')
                ->references('id')->on('cities')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->tinyInteger('deliver_time');
            $table->tinyInteger('status');
            $table->text('address')->nullable();
            $table->time('from_time');
            $table->time('to_time');
            $table->date('start_date');
            $table->date('end_date');

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
