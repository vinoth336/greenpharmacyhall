<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableMembersAddColumnsForPharma extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_pharma_product')->default(0)->after('background_image');
            $table->boolean('is_scheduled_drug')->default(0)->after('is_pharma_product');
            $table->boolean('is_for_sales')->default(1)->after('is_scheduled_drug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['is_pharma_product', 'is_scheduled_drug', 'is_for_sale']);
        });
    }
}
