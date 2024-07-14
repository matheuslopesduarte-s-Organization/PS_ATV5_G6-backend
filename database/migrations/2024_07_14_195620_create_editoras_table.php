<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('editoras', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 255);
            $table->string('endereco', 255)->nullable();
            $table->string('telefone', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('site', 100)->nullable();
            $table->json('misc')->nullable();
            $table->timestamps(); // Adiciona created_at e updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('editoras');
    }
};
