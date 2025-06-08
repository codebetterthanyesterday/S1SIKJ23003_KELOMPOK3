<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id('id_payment');
            $table->unsignedBigInteger('id_order');
            $table->enum('method', ['transfer', 'cod', 'dana', 'shopeepay', 'gopay', 'ovo']);
            $table->enum('payment_category', ['transfer', 'cod', 'ewallet'])->default('transfer');
            $table->enum('payment_status', ['unpaid', 'paid', 'failed']);
            $table->dateTime('payment_date')->nullable();
            $table->string('payment_document')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('id_order')->references('id_order')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
