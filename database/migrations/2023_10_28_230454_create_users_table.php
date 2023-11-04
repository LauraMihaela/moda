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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            //$table->bigIncrements('id')->unsigned();
            $table->string('username')->unique()->index()->comment("Username given by the user that they would use to log in");
            $table->string('password')->comment("User password. It will be stored as a hash");
            $table->string('name')->nullable()->comment("User real name");
            $table->string('lastname')->nullable()->comment("User real lastname");
            $table->string('email',100)->unique()->index()->comment("User email");
            $table->string('remember_token', 500)->comment('Remember password token');
            $table->unsignedBigInteger("role_id")->comment("Role of the current user (Relationship between the user and the role)");
            // El id de laravel por defecto se crea con el tipo "unsignedBigInteger"
            // Para que sean compatibles, el campo que será fk, debe ser también unsignedBigInteger
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
