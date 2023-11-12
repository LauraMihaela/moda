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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            // $table->bigIncrements('id')->unsigned();
            // Se crea el campo id, que es autoincremental, y no tiene signo (solo es positivo)
            $table->string("address")->nullable()->comment("Client address");
            // Con el index creamos el campo como indexable (se puede buscar)
            $table->unsignedBigInteger("user_id")->comment("Relationship with the user id of the current client");
            // Un cliente es también un usuario
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
