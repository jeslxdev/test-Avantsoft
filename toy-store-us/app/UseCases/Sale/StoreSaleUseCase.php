<?php

namespace App\UseCases\Sale;

use Illuminate\Http\Request;
use App\Models\Sale;

class StoreSaleUseCase
{
    public function execute(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'data_venda' => 'required|date',
            'valor' => 'required|numeric',
            'parcelada' => 'required|boolean',
            'metodo_pagamento' => 'required|string',
            'status_venda' => 'required|in:em analise,enviado,em rota,devolvida,concluida',
            'status_pagamento' => 'required|in:pagamento confirmado,pagamento recusado,pagamento em processamento,devolução,estornado',
        ]);
        return Sale::create($validated);
    }
}
