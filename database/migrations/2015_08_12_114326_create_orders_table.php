<?php

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
            $table->integer('user_id')->default(-1);
            $table->enum('status',['placed','on_the_way','delivered']);
            $table->string('email');
            $table->string('address');
            $table->string('phone',10);
            $table->float('delivery_charge')->default(0);
            $table->float('item_total')->default(0);
            $table->enum('payment_type',['cod','online']);
            $table->boolean('payment_recieved')->default(1);
            $table->datetime('delivered_at')->nullable();
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
        Schema::drop('orders');
    }
}
