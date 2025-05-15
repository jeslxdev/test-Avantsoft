<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'data_venda',
        'valor',
        'parcelada',
        'metodo_pagamento',
        'status_venda',
        'status_pagamento',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}

