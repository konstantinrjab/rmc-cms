<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Employee;
use App\Models\Journey;
use App\Models\JourneyTransaction;
use App\Models\Locality;
use App\Models\Trip;
use App\Models\Truck;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class JourneySeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();

        $truckIds = Truck::select('id')->toBase()->get()->pluck('id')->toArray();
        $employeeIds = Employee::select('id')->toBase()->get()->pluck('id')->toArray();
        $clientIds = Client::factory(20)->create()->pluck('id')->toArray();
        $localityIds = Locality::select('id')->toBase()->get()->pluck('id')->toArray();

        $journeys = Journey::factory(20)->make();
        foreach ($journeys as $journey) {
            $journey->employee_id = Arr::random($employeeIds);
            $journey->save();

            $trips = Trip::factory(rand(3, 5))->make();
            foreach ($trips as $trip) {
                $trip->client_id = Arr::random($clientIds);
                $trip->locality_from_id = Arr::random($localityIds);
                $trip->locality_to_id = Arr::random($localityIds);

                if ($trip->delivery_status == Trip::DELIVERY_STATUS_ORDERED) {
                    $trip->truck_id = null;
                    $trip->employee_id = null;
                    $trip->start_time = null;
                    $trip->finish_time = null;
                    $trip->journey_id = null;
                } else {
                    $trip->truck_id = Arr::random($truckIds);
                    $trip->employee_id = $journey->employee_id;
                    $trip->start_time = $faker->dateTimeBetween($journey->date_from, $journey->date_to);
                    $trip->finish_time = $faker->dateTimeBetween($trip->start_time, $journey->date_to);
                    $trip->journey_id = $journey->id;
                }

                $trip->save();
            }
        }
        $journeyIds = $journeys->pluck('id')->toArray();

        foreach ($journeyIds as $journeyId) {
            for ($i = 1; $i < random_int(0, 5); $i++) {
                JourneyTransaction::factory()->create([
                    'journey_id' => $journeyId,
                ]);
            }
        }
    }
}
