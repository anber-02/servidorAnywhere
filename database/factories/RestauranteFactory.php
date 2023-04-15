<?php

namespace Database\Factories;

use App\Models\Restaurantes;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Restaurantes>
 */
class RestauranteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Restaurantes::class;
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
