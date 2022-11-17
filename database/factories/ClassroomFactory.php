<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Model;
use App\Models\Classrooms;
use Illuminate\Support\Str;
use faker\Generator;

class ClassroomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'name' => $this->faker->name(),
            'icon' => $this->faker->name(),
            'description' => $this->faker->text(),
            'createdBy' => $this->faker->randomDigit(),
            'state' => $this->faker->numberBetween(0, 1),

        ];
    }
}
