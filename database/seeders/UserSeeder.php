<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Orchid\Support\Facades\Dashboard;

class UserSeeder extends Seeder
{
    public function run()
    {
        $admin = User::create([
            'name'        => 'admin',
            'email'       => 'admin@admin.loc',
            'password'    => Hash::make('123'),
        ]);

        $admin->forceFill([
            'permissions' => Dashboard::getAllowAllPermission(),
        ])->save();
    }
}
