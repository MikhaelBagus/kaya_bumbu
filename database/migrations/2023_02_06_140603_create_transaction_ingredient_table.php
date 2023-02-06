<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionIngredientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_ingredient', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_product_id')->references('id')->on('transaction_product')->onDelete('cascade');
            $table->foreignId('ingredient_id')->references('id')->on('ingredient')->onDelete('cascade');
            $table->double('qty');
            $table->string('created_by')->default('');
            $table->string('updated_by')->default('');
            $table->string('deleted_by')->default('');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_ingredient');
    }
}
