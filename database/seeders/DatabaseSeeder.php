<?php

namespace Database\Seeders;

use App\Models\Journey;
use App\Models\Locality;
use App\Models\Trip;
use App\Models\Truck;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Orchid\Support\Facades\Dashboard;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $admin = \App\Models\User::create([
            'name'        => 'admin',
            'email'       => 'admin@admin.loc',
            'password'    => Hash::make('123'),
        ]);

        $admin->forceFill([
            'permissions' => Dashboard::getAllowAllPermission(),
        ])->save();

        $clientIds = \App\Models\Client::factory(20)->create()->pluck('id')->toArray();

        $employeeIds = \App\Models\Employee::factory(10)->create()->pluck('id')->toArray();
        $transactions = \App\Models\FuelTransaction::factory(100)->make();

        foreach ($transactions as $transaction) {
            $transaction->operator_id = Arr::random($employeeIds);
            $transaction->subject_id = Arr::random($employeeIds);
            $transaction->save();
        }

        $csv = array_map('str_getcsv', file(__DIR__ . '/localities.csv'));

        $chunks = collect($csv)->map(function (array $record, $key) {
            return array_combine(['region', 'district', 'name', 'longitude', 'latitude'], $record);
        })->chunk(200);

        foreach ($chunks as $chunk) {
            DB::table('localities')->insert($chunk->toArray());
            break;
        }
        $localityIds = Locality::select('id')->toBase()->get()->pluck('id')->toArray();

        $trucks = Truck::factory(20)->make();
        foreach ($trucks as $truck) {
            $truck->employee_id = Arr::random($employeeIds);
            $truck->save();
        }
        $truckIds = Truck::select('id')->toBase()->get()->pluck('id')->toArray();

        $journeys = Journey::factory(20)->create();
        $journeyIds = $journeys->pluck('id')->toArray();

        $trips = Trip::factory(100)->make();
        foreach ($trips as $trip) {
            $trip->client_id = Arr::random($clientIds);
            $trip->truck_id = Arr::random($truckIds);
            $trip->employee_id = Arr::random($employeeIds);
            $trip->locality_from_id = Arr::random($localityIds);
            $trip->locality_to_id = Arr::random($localityIds);
            $trip->save();
        }

        foreach ($trips as $trip) {
            $trip->journey_id = Arr::random($journeyIds);
            $trip->save();
        }
    }
}
