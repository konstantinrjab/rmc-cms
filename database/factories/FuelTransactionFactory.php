<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FuelTransaction>
 */
class FuelTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'transaction_type' => $this->faker->randomElement(['purchase', 'sale']),
            'fuel_type' => 'diesel',
            'quantity' => $this->faker->numberBetween(50, 1000),
            'subject_id' => 1,
            'operator_id' => 1,
            'info' => null,
            'datetime' => $this->faker->dateTimeBetween('-1 week'),
        ];
    }
}
