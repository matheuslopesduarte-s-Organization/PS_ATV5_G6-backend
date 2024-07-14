<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livro extends Model
{
    use HasFactory;

    protected $table = 'livros';

    protected $fillable = [
        'titulo',
        'autor_id',
        'editora_id',
        'genero_id',
        'classificacao_id',
        'ano_publicacao',
        'isbn',
        'paginas',
        'descricao',
        'data_adicionado',
        'misc'
    ];

    public function autor()
    {
        return $this->belongsTo(Autor::class, 'autor_id');
    }

    public function editora()
    {
        return $this->belongsTo(Editora::class, 'editora_id');
    }

    public function genero()
    {
        return $this->belongsTo(Genero::class, 'genero_id');
    }

    public function classificacaoIndicativa()
    {
        return $this->belongsTo(ClassificacaoIndicativa::class, 'classificacao_id');
    }

    public function idiomas()
    {
        return $this->belongsToMany(Idioma::class, 'livros_idiomas', 'livro_id', 'idioma_id')
                    ->withPivot('exemplares_disponiveis', 'misc')
                    ->withTimestamps();
    }
}
