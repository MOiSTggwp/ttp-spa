<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ModFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->lastName(),
            'tag' => $this->faker->lastName(),
            'main_mod_id' => $this->faker->numberBetween(1, 3),
            'second_mod_id' => $this->faker->numberBetween(4, 6),
        ];
    }
}
