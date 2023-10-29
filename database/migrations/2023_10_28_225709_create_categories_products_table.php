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
        /* 
         Esta migración crea una tabla de unión relaciona los productos con las categorías,
         ya que las catagorías y los productos tiene una relación M:N
         */
        Schema::create('categories_products', function (Blueprint $table) {
            $table->id();
            //$table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger("product_id")->comment("Relationship with the product");
            $table->unsignedBigInteger("category_id")->comment("Relationship with the category");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories_products');
    }
};
