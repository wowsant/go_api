<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Situacao extends Model
{
    protected $table =  'situacoes';

    protected $fillable = [
        'descricao', 'classe'
    ];

    static function verificaDescricao($dados) {
        return Situacao::where('descricao', $dados)->count();
    }
}
