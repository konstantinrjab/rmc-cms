<?php

namespace Database\Factories;

use App\Models\FuelTransaction;
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
            'transaction_type' => $this->faker->randomElement([FuelTransaction::TYPE_INCOME, FuelTransaction::TYPE_EXPENSE]),
            'fuel_type'        => 'diesel',
            'quantity'         => $this->faker->numberBetween(50, 1000),
            'source_id'        => $this->faker->numberBetween(1, 3),
            'truck_id'         => null,
            'consumer_type'    => $this->faker->boolean(80) ? FuelTransaction::TYPE_TRUCK : $this->faker->randomElement([FuelTransaction::TYPE_OWN_STATION, FuelTransaction::TYPE_OTHER]),
            'price'            => $this->faker->numberBetween(25, 35),
            'operator_id'      => 1,
            'comment'          => $this->faker->boolean ? $this->faker->sentence : null,
            'datetime'         => $this->faker->dateTimeBetween('-1 week'),
        ];
    }
}
