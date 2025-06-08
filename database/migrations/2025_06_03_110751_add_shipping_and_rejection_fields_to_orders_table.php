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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('tracking_number')->nullable()->after('order_status');
            $table->text('shipping_notes')->nullable()->after('tracking_number');
            $table->text('rejection_reason')->nullable()->after('shipping_notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('tracking_number');
            $table->dropColumn('shipping_notes');
            $table->dropColumn('rejection_reason');
        });
    }
};
