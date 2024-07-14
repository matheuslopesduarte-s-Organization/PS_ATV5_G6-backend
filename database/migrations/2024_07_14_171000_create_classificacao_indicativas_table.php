<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('classificacoes_indicativas', function (Blueprint $table) {
            $table->id();
            $table->string('classificacao', 50);
            $table->json('misc')->nullable();
            $table->timestamps(); // Adiciona created_at e updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('classificacoes_indicativas');
    }
};
