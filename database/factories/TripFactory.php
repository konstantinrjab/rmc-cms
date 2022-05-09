<?php

namespace Database\Factories;

use App\Models\Trip;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Trip>
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
            'journey_id'       => 1,
            'client_id'        => 1,
            'employee_id'      => 1,
            'truck_id'         => 1,
            'locality_from_id' => 1,
            'locality_to_id'   => 1,
            'status'           => $this->faker->randomElement([Trip::STATUS_ORDERED, Trip::STATUS_IN_PROGRESS, Trip::STATUS_DONE]),
            'distance'          => $this->faker->randomNumber(3),
            'fuel_remains'     => $this->faker->numberBetween(50, 1000),
            'start_time'       => $this->faker->dateTimeBetween('-1 week'),
            'finish_time'      => $this->faker->dateTimeBetween('-1 week'),
        ];
    }
}
