<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emprestimo extends Model
{
    use HasFactory;

    protected $table = 'emprestimos';

    protected $fillable = [
        'livro_id',
        'usuario_id',
        'data_emprestimo',
        'data_devolucao',
        'data_prevista_devolucao',
        'misc'
    ];

    public function livro()
    {
        return $this->belongsTo(Livro::class, 'livro_id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}
