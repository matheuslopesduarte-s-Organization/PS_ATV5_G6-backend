<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('livros_idiomas', function (Blueprint $table) {
            $table->unsignedBigInteger('livro_id');
            $table->unsignedBigInteger('idioma_id');
            $table->integer('exemplares_disponiveis')->default(0);
            $table->json('misc')->nullable();
            $table->timestamps();

            $table->primary(['livro_id', 'idioma_id']);

            // Define foreign keys
            $table->foreign('livro_id')->references('id')->on('livros')->onDelete('cascade');
            $table->foreign('idioma_id')->references('id')->on('idiomas')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('livros_idiomas');
    }
};
