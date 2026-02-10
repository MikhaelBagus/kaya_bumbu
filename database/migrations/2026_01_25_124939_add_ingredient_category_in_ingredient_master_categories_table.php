<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ingredient_master_categories', function (Blueprint $table) {
            //
            $table->bigInteger('ingredient_master_group_id')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ingredient_master_categories', function (Blueprint $table) {
            //
            $table->dropColumn(['ingredient_master_group_id']);
        });
    }
};
