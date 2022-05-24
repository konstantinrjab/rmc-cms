<?php

declare(strict_types=1);

use App\Orchid\Screens\Examples\ExampleCardsScreen;
use App\Orchid\Screens\Examples\ExampleChartsScreen;
use App\Orchid\Screens\Examples\ExampleFieldsAdvancedScreen;
use App\Orchid\Screens\Examples\ExampleFieldsScreen;
use App\Orchid\Screens\Examples\ExampleLayoutsScreen;
use App\Orchid\Screens\Examples\ExampleScreen;
use App\Orchid\Screens\Examples\ExampleTextEditorsScreen;
use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/

// Main
Route::screen('/main', PlatformScreen::class)
    ->name('platform.main');

// Platform > Profile
Route::screen('profile', UserProfileScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Profile'), route('platform.profile'));
    });

// Platform > System > Users
Route::screen('users/{user}/edit', UserEditScreen::class)
    ->name('platform.systems.users.edit')
    ->breadcrumbs(function (Trail $trail, $user) {
        return $trail
            ->parent('platform.systems.users')
            ->push(__('User'), route('platform.systems.users.edit', $user));
    });

// Platform > System > Users > Create
Route::screen('users/create', UserEditScreen::class)
    ->name('platform.systems.users.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.systems.users')
            ->push(__('Create'), route('platform.systems.users.create'));
    });

// Platform > System > Users > User
Route::screen('users', UserListScreen::class)
    ->name('platform.systems.users')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Users'), route('platform.systems.users'));
    });

// Platform > System > Roles > Role
Route::screen('roles/{role}/edit', RoleEditScreen::class)
    ->name('platform.systems.roles.edit')
    ->breadcrumbs(function (Trail $trail, $role) {
        return $trail
            ->parent('platform.systems.roles')
            ->push(__('Role'), route('platform.systems.roles.edit', $role));
    });

// Platform > System > Roles > Create
Route::screen('roles/create', RoleEditScreen::class)
    ->name('platform.systems.roles.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.systems.roles')
            ->push(__('Create'), route('platform.systems.roles.create'));
    });

// Platform > System > Roles
Route::screen('roles', RoleListScreen::class)
    ->name('platform.systems.roles')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Roles'), route('platform.systems.roles'));
    });

// Example...
Route::screen('example', ExampleScreen::class)
    ->name('platform.example')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push('Example screen');
    });

Route::screen('example-fields', ExampleFieldsScreen::class)->name('platform.example.fields');
Route::screen('example-layouts', ExampleLayoutsScreen::class)->name('platform.example.layouts');
Route::screen('example-charts', ExampleChartsScreen::class)->name('platform.example.charts');
Route::screen('example-editors', ExampleTextEditorsScreen::class)->name('platform.example.editors');
Route::screen('example-cards', ExampleCardsScreen::class)->name('platform.example.cards');
Route::screen('example-advanced', ExampleFieldsAdvancedScreen::class)->name('platform.example.advanced');

//Route::screen('idea', Idea::class, 'platform.screens.idea');

// employees
Route::screen('employees', \App\Orchid\Screens\Employee\EmployeeListScreen::class)
    ->name('platform.employees')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Employees'), route('platform.employees'));
    });

Route::screen('employees/{employees}/edit', \App\Orchid\Screens\Employee\EmployeeEditScreen::class)
    ->name('platform.employees.edit')
    ->breadcrumbs(function (Trail $trail, $user) {
        return $trail
            ->parent('platform.employees')
            ->push(__('Employees'), route('platform.employees.edit', $user));
    });

Route::screen('employees/create', \App\Orchid\Screens\Employee\EmployeeEditScreen::class)
    ->name('platform.employees.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.employees')
            ->push(__('Create'), route('platform.employees.create'));
    });

// clients
Route::screen('clients', \App\Orchid\Screens\Client\ClientListScreen::class)
    ->name('platform.clients')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Clients'), route('platform.clients'));
    });

Route::screen('clients/{client}/edit', \App\Orchid\Screens\Client\ClientEditScreen::class)
    ->name('platform.clients.edit')
    ->breadcrumbs(function (Trail $trail, $user) {
        return $trail
            ->parent('platform.clients')
            ->push(__('Clients'), route('platform.clients.edit', $user));
    });

Route::screen('clients/create', \App\Orchid\Screens\Client\ClientEditScreen::class)
    ->name('platform.clients.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.clients')
            ->push(__('Create'), route('platform.clients.create'));
    });

Route::screen('clients/{client}', \App\Orchid\Screens\Client\ClientItemScreen::class)
    ->name('platform.clients.item')
    ->breadcrumbs(function (Trail $trail, $user) {
        return $trail
            ->parent('platform.clients')
            ->push(__('Clients'), route('platform.clients.item', $user));
    });

// localities
Route::screen('localities', \App\Orchid\Screens\Locality\LocalityListScreen::class)
    ->name('platform.localities')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Localities'), route('platform.localities'));
    });

Route::screen('localities/{locality}/edit', \App\Orchid\Screens\Locality\LocalityEditScreen::class)
    ->name('platform.localities.edit')
    ->breadcrumbs(function (Trail $trail, $user) {
        return $trail
            ->parent('platform.localities')
            ->push(__('Localities'), route('platform.localities.edit', $user));
    });

Route::screen('localities/create', \App\Orchid\Screens\Locality\LocalityEditScreen::class)
    ->name('platform.localities.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.localities')
            ->push(__('Create'), route('platform.localities.create'));
    });

// trucks
Route::screen('trucks', \App\Orchid\Screens\Truck\TruckListScreen::class)
    ->name('platform.trucks')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Trucks'), route('platform.trucks'));
    });

Route::screen('trucks/{truck}/edit', \App\Orchid\Screens\Truck\TruckEditScreen::class)
    ->name('platform.trucks.edit')
    ->breadcrumbs(function (Trail $trail, $user) {
        return $trail
            ->parent('platform.trucks')
            ->push(__('Trucks'), route('platform.trucks.edit', $user));
    });

Route::screen('trucks/create', \App\Orchid\Screens\Truck\TruckEditScreen::class)
    ->name('platform.trucks.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.trucks')
            ->push(__('Create'), route('platform.trucks.create'));
    });

// trips
Route::screen('trips', \App\Orchid\Screens\Trip\TripListScreen::class)
    ->name('platform.trips')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Trips'), route('platform.trips'));
    });

Route::screen('trips/{truck}/edit', \App\Orchid\Screens\Trip\TripEditScreen::class)
    ->name('platform.trips.edit')
    ->breadcrumbs(function (Trail $trail, $user) {
        return $trail
            ->parent('platform.trips')
            ->push(__('Trips'), route('platform.trips.edit', $user));
    });

Route::screen('trips/create', \App\Orchid\Screens\Trip\TripEditScreen::class)
    ->name('platform.trips.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.trips')
            ->push(__('Create'), route('platform.trips.create'));
    });

// journeys
Route::screen('journeys', \App\Orchid\Screens\Journey\JourneyListScreen::class)
    ->name('platform.journeys')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Journeys'), route('platform.journeys'));
    });

Route::screen('journeys/{journey}/edit', \App\Orchid\Screens\Journey\JourneyEditScreen::class)
    ->name('platform.journeys.edit')
    ->breadcrumbs(function (Trail $trail, $user) {
        return $trail
            ->parent('platform.journeys')
            ->push(__('Journeys'), route('platform.journeys.edit', $user));
    });

Route::screen('journeys/create', \App\Orchid\Screens\Journey\JourneyEditScreen::class)
    ->name('platform.journeys.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.journeys')
            ->push(__('Create'), route('platform.journeys.create'));
    });

Route::screen('journeys/{journey}', \App\Orchid\Screens\Journey\JourneyItemScreen::class)
    ->name('platform.journeys.item')
    ->breadcrumbs(function (Trail $trail, $user) {
        return $trail
            ->parent('platform.journeys')
            ->push(__('Journeys'), route('platform.journeys.item', $user));
    });


// fuel transactions
Route::screen('fuel-transactions', \App\Orchid\Screens\Fuel\FuelTransactionListScreen::class)
    ->name('platform.fuel_transactions')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Fuel Transactions'), route('platform.fuel_transactions'));
    });


Route::screen('fuel-transactions/{fuelTransaction}/edit', \App\Orchid\Screens\Fuel\FuelTransactionEditScreen::class)
    ->name('platform.fuel_transactions.edit')
    ->breadcrumbs(function (Trail $trail, $transaction) {
        return $trail
            ->parent('platform.fuel_transactions')
            ->push(__('Fuel Transactions'), route('platform.fuel_transactions.edit', $transaction));
    });

Route::screen('fuel-transactions/create', \App\Orchid\Screens\Fuel\FuelTransactionEditScreen::class)
    ->name('platform.fuel_transactions.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.fuel_transactions')
            ->push(__('Create'), route('platform.fuel_transactions.create'));
    });

Route::screen('fuel-transactions/analytics', \App\Orchid\Screens\Fuel\FuelTransactionAnalyticsScreen::class)
    ->name('platform.fuel_transactions.analytics')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Analytics'), route('platform.fuel_transactions.analytics'));
    });

Route::screen('fuel-transactions/{fuelTransaction}', \App\Orchid\Screens\Fuel\FuelTransactionItemScreen::class)
    ->name('platform.fuel_transactions.item')
    ->breadcrumbs(function (Trail $trail, $user) {
        return $trail
            ->parent('platform.fuel_transactions')
            ->push(__('Fuel Transactions'), route('platform.fuel_transactions.item', $user));
    });
