<?php

namespace Database\Factories;

use App\Models\Comentarios;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comentarios>
 */
class ComentarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Comentarios::class;
    public function definition(): array
    {
        return [
            //$table->id('idComen');
            'comentario' => $this->faker->text(),
            'usuarios_idUsuarios'=>$this->faker->randomElement([1,2,3,4,5,6,7,8,9,10])
        ];
    }
}






