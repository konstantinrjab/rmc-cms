<?php

namespace Database\Factories;

use App\Orchid\Layouts\Trip\TripStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class TripFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'client_id'        => 1,
            'employee_id'      => 1,
            'truck_id'         => 1,
            'locality_from_id' => 1,
            'locality_to_id'   => 1,
            'status'           => $this->faker->randomElement(TripStatus::values()),
            'mileage'          => $this->faker->randomNumber(3),
            'fuel_remains'     => $this->faker->numberBetween(50, 1000),
            'fuel_refill'      => $this->faker->numberBetween(50, 200),
            'start_time'       => $this->faker->dateTimeBetween('-1 week'),
            'finish_time'      => $this->faker->dateTimeBetween('-1 week'),
        ];
    }
}
