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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            //$table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger("client_id")->comment("Relationship with the client that bought the product, making the shippment");
            $table->unsignedBigInteger("sizes_colors_products_id")->comment("Shipping relationship with the product and its color and size (the client bought products)");
            $table->unsignedBigInteger("status_id")->nullable()->comment("Relationship with the shipping status (initial, shipped, ongoing, rejected, completed)");
            // Se permite que los envíos tengan un estado en null (con nulleable)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
