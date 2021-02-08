<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSendMessageToAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('send_message_to_admin', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('user_id');
            $table->string('status');
            $table->text('comment')->nullable();
            $table->string('attachment', 500)->nullable();
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
        Schema::dropIfExists('send_message_to_admin');
    }
}
