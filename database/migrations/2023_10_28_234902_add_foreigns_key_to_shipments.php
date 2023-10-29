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
        Schema::table('shipments', function (Blueprint $table) {
            // Añadir fks
            $table->foreign("client_id")->references("id")->on("clients")
            ->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("sizes_colors_products_id")->references("id")->on("sizes_colors_products")
            ->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("status_id")->references("id")->on("status")
            ->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shipments', function (Blueprint $table) {
            // Eliminar fk
             $table->dropForeign(['client_id']);
             $table->dropForeign(['sizes_colors_products_id']);
             $table->dropForeign(['status_id']);
        });
    }
};
