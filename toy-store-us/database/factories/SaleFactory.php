<?php

namespace Database\Factories;

use App\Models\Sale;
use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleFactory extends Factory
{
    protected $model = Sale::class;

    public function definition()
    {
        return [
            'cliente_id' => Cliente::factory(),
            'data_venda' => $this->faker->date(),
            'valor' => $this->faker->randomFloat(2, 10, 1000),
            'parcelada' => $this->faker->boolean(),
            'metodo_pagamento' => $this->faker->randomElement(['cartao', 'boleto', 'pix']),
            'status_venda' => $this->faker->randomElement(['em analise','enviado','em rota','devolvida','concluida']),
            'status_pagamento' => $this->faker->randomElement(['pagamento confirmado','pagamento recusado','pagamento em processamento','devolução','estornado']),
        ];
    }
}
