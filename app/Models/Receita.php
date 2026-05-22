<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receita extends Model
{
    protected $table = 'receitas';

    protected $fillable = [
        'titulo',
        'descricao',
        'ingredientes',
        'modo_preparo',
    ];

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'titulo' => $this->titulo,
            'descricao' => $this->descricao,
            'ingredientes' => $this->ingredientes,
            'modo_preparo' => $this->modo_preparo,
        ];
    }
}