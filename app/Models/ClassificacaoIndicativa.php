<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassificacaoIndicativa extends Model
{
    use HasFactory;

    protected $table = 'classificacoes_indicativas';

    protected $fillable = [
        'classificacao',
        'misc'
    ];
}
