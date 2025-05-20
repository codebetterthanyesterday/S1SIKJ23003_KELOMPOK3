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
        Schema::create('products', function (Blueprint $table) {
            $table->id('id_product');
            $table->unsignedBigInteger('id_store');
            $table->unsignedBigInteger('id_category');
            $table->string('product_name', 100);
            $table->string('slug', 255)->unique();
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->integer('stock');
            $table->string('product_image')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_store')->references('id_store')->on('stores');
            $table->foreign('id_category')->references('id_category')->on('product_categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
