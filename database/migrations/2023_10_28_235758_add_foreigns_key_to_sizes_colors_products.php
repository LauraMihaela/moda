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
        Schema::table('sizes_colors_products', function (Blueprint $table) {
            // Añadir fks
            $table->foreign("product_id")->references("id")->on("products")
            ->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("color_id")->references("id")->on("colors")
            ->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("size_id")->references("id")->on("sizes")
            ->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sizes_colors_products', function (Blueprint $table) {
            // Eliminar fk
             $table->dropForeign(['product_id']);
             $table->dropForeign(['color_id']);
             $table->dropForeign(['size_id']);
        });
    }
};
