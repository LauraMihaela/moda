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
        Schema::create('sizes_colors_products', function (Blueprint $table) {
            $table->id();
            //$table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger("product_id")->comment("Relationship with the product");
            $table->unsignedBigInteger("color_id")->nullable()->comment("Relationship with the product color");
            $table->unsignedBigInteger("size_id")->nullable()->comment("Relationship with the product size");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sizes_colors_products');
    }
};
