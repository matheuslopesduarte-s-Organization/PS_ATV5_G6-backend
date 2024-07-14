<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('autores', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 255);
            $table->text('biografia')->nullable();
            $table->date('data_nascimento')->nullable();
            $table->string('nacionalidade', 100)->nullable();
            $table->json('misc')->nullable();
            $table->timestamps(); // Adiciona created_at e updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('autores');
    }
};
