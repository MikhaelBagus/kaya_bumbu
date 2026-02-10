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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('code')->default(''); // Purchase order code/number
            $table->date('purchase_date')->nullable();
            $table->date('approve_date')->nullable();
            $table->foreignId('warehouse_id')->nullable()->constrained('warehouse')->onDelete('cascade');
            $table->foreignId('supplier_id')->nullable()->constrained('supplier')->onDelete('cascade');
            $table->foreignId('supplier_account_id')->nullable()->constrained('supplier_accounts')->onDelete('cascade');
            $table->foreignId('payment_method_id')->nullable()->constrained('payment_method')->onDelete('cascade');
            $table->foreignId('wallet_id')->nullable()->constrained('wallet')->onDelete('cascade');
            $table->foreignId('expenditure_type_id')->nullable()->constrained('expenditure_type')->onDelete('cascade');
            $table->double('subtotal')->default(0);
            $table->double('discount')->default(0);
            $table->double('cost')->default(0);
            $table->double('total_purchase')->default(0);
            $table->text('notes')->nullable();
            $table->double('instalment_count')->default(0);
            $table->double('down_payment')->default(0);
            $table->date('down_payment_date')->nullable();
            $table->string('status')->default('draft');
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
        Schema::dropIfExists('purchases');
    }
};
