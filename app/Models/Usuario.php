<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuarios';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'nome',
        'email',
        'senha',
        'cpf',
        'username',
        'misc',
        'birthdate'
    ];

    protected $hidden = [
        'senha',
    ];
    protected $casts = [
        'misc' => 'array',
    ];

    public $timestamps = false;
}

