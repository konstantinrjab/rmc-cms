<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocalitySeeder extends Seeder
{
    public function run()
    {
        $csv = array_map('str_getcsv', file(__DIR__ . '/resource/localities.csv'));

        $chunks = collect($csv)->map(function (array $record, $key) {
            return array_combine(['region', 'district', 'name', 'longitude', 'latitude'], $record);
        })->chunk(200);

        foreach ($chunks as $chunk) {
            DB::table('localities')->insert($chunk->toArray());
            break;
        }
    }
}
