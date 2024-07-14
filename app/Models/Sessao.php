<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sessao extends Model
{
    use HasFactory;

    protected $table = 'sessoes';
    public $incrementing = false; 

    protected $fillable = [
        'id',
        'dispositivo',
        'usuario_id',
        'expiracao',
        'estado',
        'misc'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}
