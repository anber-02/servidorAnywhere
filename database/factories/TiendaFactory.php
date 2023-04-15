<?php

namespace Database\Factories;

use App\Models\Tiendas;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tiendas>
 */
class TiendaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Tiendas::class;
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->name(), 
            'direccion' => $this->faker->address(), 
            'contacto_tel' => $this->faker->phoneNumber(),
            'contacto_correo' => $this->faker->email()
        ];
    }

    
}
