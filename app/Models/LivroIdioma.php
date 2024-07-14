<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class LivroIdioma extends Pivot
{
    use HasFactory;

    protected $table = 'livros_idiomas';

    protected $fillable = [
        'livro_id',
        'idioma_id',
        'exemplares_disponiveis',
        'misc'
    ];

    public function livro()
    {
        return $this->belongsTo(Livro::class, 'livro_id');
    }

    public function idioma()
    {
        return $this->belongsTo(Idioma::class, 'idioma_id');
    }
}

