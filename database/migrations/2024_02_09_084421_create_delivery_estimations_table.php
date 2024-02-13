<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryEstimationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_estimations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pincode_id');
            $table->integer('min')->default('1');
            $table->integer('max');
            $table->timestamps();
            $table->foreign('pincode_id')->references('id')->on('pincodes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_estimations');
    }
}
