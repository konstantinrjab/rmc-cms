<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Employee;
use App\Models\Locality;
use App\Models\Truck;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class BaseEntitiesSeeder extends Seeder
{
    public function run()
    {
        $clientIds = Client::factory(20)->create()->pluck('id')->toArray();
        $employeeIds = Employee::factory(10)->create()->pluck('id')->toArray();

        $localityIds = Locality::select('id')->toBase()->get()->pluck('id')->toArray();

        $trucks = Truck::factory(20)->make();
        foreach ($trucks as $truck) {
            $truck->employee_id = Arr::random($employeeIds);
            $truck->save();
        }
    }
}
