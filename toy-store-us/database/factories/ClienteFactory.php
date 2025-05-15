<?php

namespace Database\Factories;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ClienteFactory extends Factory
{
    protected $model = Cliente::class;

    public function definition()
    {
        $tipo = $this->faker->randomElement(['fisica', 'juridica']);
        return [
            'nome' => $this->faker->name(),
            'razao_social' => $tipo === 'juridica' ? $this->faker->company : null,
            'nome_fantasia' => $tipo === 'juridica' ? $this->faker->companySuffix : null,
            'email' => $this->faker->unique()->safeEmail(),
            'cpfCnpj' => $tipo === 'fisica'
                ? $this->faker->numerify('###.###.###-##')
                : $this->faker->numerify('##.###.###/####-##'),
            'telefone' => $this->faker->phoneNumber(),
            'endereco' => $this->faker->streetAddress(),
            'cidade' => $this->faker->city(),
            'estado' => $this->faker->stateAbbr(),
            'cep' => $this->faker->postcode(),
            'pais' => $this->faker->country(),
            'tipo_cliente' => $tipo,
            'data_nascimento' => $this->faker->date('Y-m-d', '-18 years')
        ];
    }
}
