<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'razao_social',
        'nome_fantasia',
        'email',
        'cpfCnpj',
        'telefone',
        'endereco',
        'cidade',
        'estado',
        'cep',
        'pais',
        'tipo_cliente',
        'data_nascimento',
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class, 'cliente_id');
    }
}

