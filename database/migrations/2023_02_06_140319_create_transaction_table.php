<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('customer_id')->references('id')->on('customer')->onDelete('cascade');
            $table->foreignId('source_id')->references('id')->on('source')->onDelete('cascade');
            $table->foreignId('bank_id')->references('id')->on('bank')->onDelete('cascade');
            $table->foreignId('city_id')->references('id')->on('city')->onDelete('cascade');
            $table->string('code')->default('');
            $table->date('date')->nullable();
            $table->string('time')->default('00:00');
            $table->string('customer_name')->default('');
            $table->string('customer_phone')->default('');
            $table->string('recipient_name')->default('');
            $table->string('recipient_phone')->default('');
            $table->string('transaction_type')->default('');
            $table->string('delivery_option')->default('');
            $table->string('delivery_transport')->default('');
            $table->string('delivery_type')->default('');
            $table->integer('status')->default(0);
            $table->integer('payment_status')->default(0);
            $table->string('payment_bukti_transfer_url')->default('');
            $table->text('address')->nullable();
            $table->double('discount_price')->default(0);
            $table->double('grand_price')->default(0);
            $table->double('ongkir_price')->default(0);
            $table->double('actual_ongkir_price')->default(0);
            $table->string('tanda_terima_url')->default('');
            $table->datetime('start_cooking_at')->nullable();
            $table->string('start_cooking_by')->default('');
            $table->datetime('start_delivery_at')->nullable();
            $table->string('start_delivery_by')->default('');
            $table->datetime('end_delivery_at')->nullable();
            $table->string('end_delivery_by')->default('');
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
        Schema::dropIfExists('transaction');
    }
}
