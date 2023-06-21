<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->references('id')->on('transaction')->onDelete('cascade');
            $table->foreignId('product_id')->references('id')->on('product')->onDelete('cascade');
            $table->string('name')->default('');
            $table->double('price')->default(0);
            $table->double('qty')->default(0);
            $table->string('unit')->default('');
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('transaction_product');
    }
}
