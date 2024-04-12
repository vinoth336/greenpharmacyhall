<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Payment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments',function(Blueprint $table) {
            $table->increments('id');
            $table->foreignId('user_id');
            $table->string('order_id');
            $table->string('payment_id')->nullable();
            $table->string('payment_signature')->nullable();
            $table->decimal('amount',9,3);
            $table->string('status')->default('created');
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
        Schema::drop('payments');
    }
}
