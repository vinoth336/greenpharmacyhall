<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTablePharmaPrescriptionsModifyCommentText extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pharma_prescriptions', function (Blueprint $table) {
            $table->text('comment_text')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pharma_prescriptions', function (Blueprint $table) {
            $table->string('comment_text', 500)->change();
        });
    }
}
