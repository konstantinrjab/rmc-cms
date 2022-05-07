<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JourneyTransaction>
 */
class JourneyTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'journey_id' => 1,
            'name'       => $this->faker->word(),
            'amount'     => $this->faker->numberBetween(-1000, 1000),
            'comment'    => $this->faker->sentence(),
        ];
    }
}
