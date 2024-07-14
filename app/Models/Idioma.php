<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Idioma extends Model
{
    use HasFactory;

    protected $table = 'idiomas';

    protected $fillable = [
        'nome',
        'misc'
    ];

    public function livros()
    {
        return $this->belongsToMany(Livro::class, 'livros_idiomas', 'idioma_id', 'livro_id')
                    ->withPivot('exemplares_disponiveis', 'misc')
                    ->withTimestamps();
    }
}

