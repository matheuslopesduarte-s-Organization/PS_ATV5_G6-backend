<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->string('nome', 100);
            $table->string('email', 100)->unique();
            $table->string('senha', 64);
            $table->timestamp('data_cadastro')->useCurrent();
            $table->string('cpf', 11)->unique();
            $table->string('username', 30)->unique();
            $table->json('misc')->nullable();
            $table->date('birthdate');
            $table->timestamps(); // Adiciona created_at e updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
};
