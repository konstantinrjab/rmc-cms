<?php

namespace Database\Factories;

use App\Models\JourneyTransaction;
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
            'type'       => $this->faker->randomElement([JourneyTransaction::INCOME, JourneyTransaction::EXPENSE]),
            'name'       => $this->faker->word(),
            'amount'     => $this->faker->numberBetween(0, 1000),
            'comment'    => $this->faker->sentence(),
        ];
    }
}
