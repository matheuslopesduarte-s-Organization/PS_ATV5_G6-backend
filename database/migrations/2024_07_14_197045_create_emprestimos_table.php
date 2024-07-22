<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('emprestimos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('livro_id')->nullable();
            $table->uuid('usuario_id');
            $table->dateTime('data_emprestimo');
            $table->date('data_devolucao')->nullable();
            $table->date('data_prevista_devolucao')->nullable();
            $table->json('misc')->nullable();
            $table->timestamps();

            // Define foreign keys
            $table->foreign('livro_id')->references('id')->on('livros')->onDelete('set null');
            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('emprestimos');
    }
};
