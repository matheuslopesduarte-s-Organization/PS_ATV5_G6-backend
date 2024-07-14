<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sessoes', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->json('dispositivo');
            $table->char('usuario_id', 36);
            $table->datetime('expiracao');
            $table->enum('estado', ['ativo', 'expirado', 'revogado'])->default('ativo');
            $table->json('misc')->nullable();
            $table->timestamps();

            // Definir chave estrangeira
            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sessoes');
    }
};
