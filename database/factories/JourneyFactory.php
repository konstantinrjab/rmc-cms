<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Journey>
 */
class JourneyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'employee_id' => 1,
            'date_from'   => $this->faker->dateTimeBetween('-1 week', '-5 days'),
            'date_to'     => $this->faker->dateTimeBetween('-5 days', '-1 day'),
        ];
    }
}
