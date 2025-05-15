<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cliente;
use App\Models\Sale;
use Illuminate\Support\Str;

class ClienteSeeder extends Seeder
{
    public function run()
    {
        $clientes = Cliente::factory()->count(10)->create();

        foreach ($clientes as $cliente) {
            $numVendas = rand(1, 20);
            for ($i = 0; $i < $numVendas; $i++) {
                Sale::create([
                    'cliente_id' => $cliente->id,
                    'data_venda' => now()->subDays(rand(0, 365)),
                    'valor' => rand(50, 1000),
                    'parcelada' => rand(0, 1),
                    'metodo_pagamento' => 'cartao',
                    'status_venda' => 'concluida',
                    'status_pagamento' => collect([
                        'pagamento confirmado',
                        'pagamento recusado',
                        'pagamento em processamento',
                        'devolução',
                        'estornado',
                    ])->random(),
                ]);
            }
        }
    }
}
