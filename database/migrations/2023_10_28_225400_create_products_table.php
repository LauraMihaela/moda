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
            $table->id();
            //$table->bigIncrements('id')->unsigned();
            $table->string('product_name')->comment("Product name");
            $table->binary("picture")->nullable()->comment("Product picture");
            $table->longText("description")->nullable()->comment("Product description");
            $table->integer("units")->default(1)->comment("Product units (number of products)");
            // Unidades del producto: por defecto 1
            $table->unsignedBigInteger('created_by_fashion_designer_id')->nullable()->comment("Relationship with the fashion designer that created the product");
            $table->timestamps();
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
