<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\FuelTransaction;
use App\Models\Truck;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class FuelTransactionsSeeder extends Seeder
{
    public function run()
    {
        $truckIds = Truck::select('id')->toBase()->get()->pluck('id')->toArray();
        $employeeIds = Employee::select('id')->toBase()->get()->pluck('id')->toArray();

        $transactions = FuelTransaction::factory(100)->make();

        foreach ($transactions as $transaction) {
            $transaction->operator_id = Arr::random($employeeIds);
            if ($transaction->consumer_type == FuelTransaction::TYPE_TRUCK) {
                $transaction->truck_id = Arr::random($truckIds);
                $transaction->transaction_type = FuelTransaction::TYPE_EXPENSE;
            }
            $transaction->save();
        }
    }
}
