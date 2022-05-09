<?php

namespace Database\Factories;

use App\Models\Truck;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Truck>
 */
class TruckFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $letters = ['A', 'B', 'C', 'H', 'O', 'P'];

        $number = $this->faker->randomElement($letters) . $this->faker->randomElement($letters)
            . ' ' . $this->faker->randomNumber(4) . ' '
            . $this->faker->randomElement($letters) . $this->faker->randomElement($letters);

        return [
            'name'   => $this->faker->randomElement(['Reno', 'Volvo', 'Mercedes']) . ' ' . ucfirst($this->faker->word()),
            'number' => strtoupper($number),
            'status' => $this->faker->randomElement([Truck::STATUS_IDLE, Truck::STATUS_UNDER_REPAIR]),
        ];
    }
}
