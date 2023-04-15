<?php

namespace Database\Factories;

use App\Models\Hoteles;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hoteles>
 */
class HotelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Hoteles::class;
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
