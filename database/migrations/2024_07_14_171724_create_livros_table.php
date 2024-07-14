<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('livros', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 255);
            $table->unsignedBigInteger('autor_id')->nullable();
            $table->unsignedBigInteger('editora_id')->nullable();
            $table->unsignedBigInteger('genero_id')->nullable();
            $table->unsignedBigInteger('classificacao_id')->nullable();
            $table->year('ano_publicacao')->nullable();
            $table->string('isbn', 13)->unique()->nullable();
            $table->integer('paginas')->nullable();
            $table->text('descricao')->nullable();
            $table->timestamp('data_adicionado')->useCurrent();
            $table->json('misc')->nullable();
            $table->timestamps(); // Adiciona created_at e updated_at

            // Define foreign keys
            $table->foreign('autor_id')->references('id')->on('autores')->onDelete('set null');
            $table->foreign('editora_id')->references('id')->on('editoras')->onDelete('set null');
            $table->foreign('genero_id')->references('id')->on('generos')->onDelete('set null');
            $table->foreign('classificacao_id')->references('id')->on('classificacoes_indicativas')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('livros');
    }
};
