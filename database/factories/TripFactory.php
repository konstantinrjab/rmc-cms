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
            'delivery_status'  => $this->faker->randomElement([Trip::DELIVERY_STATUS_ORDERED, Trip::DELIVERY_STATUS_IN_PROGRESS, Trip::DELIVERY_STATUS_DONE]),
            'payment_status'   => $this->faker->randomElement([Trip::PAYMENT_STATUS_NO_INVOICE, Trip::PAYMENT_STATUS_INVOICE_SENT, Trip::PAYMENT_STATUS_PAYED]),
            'distance'         => $this->faker->randomNumber(3),
            'fuel_remains'     => $this->faker->numberBetween(50, 1000),
            'start_time'       => $this->faker->dateTimeBetween('-1 week'),
            'finish_time'      => $this->faker->dateTimeBetween('-1 week'),
        ];
    }
}
