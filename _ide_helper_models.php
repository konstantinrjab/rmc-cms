<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Client
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Client defaultSort(string $column, string $direction = 'asc')
 * @method static \Database\Factories\ClientFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Client filters(?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Client filtersApply(iterable $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Client filtersApplySelection($selection)
 * @method static \Illuminate\Database\Eloquent\Builder|Client newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Client newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Client query()
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereUpdatedAt($value)
 */
	class IdeHelperClient {}
}

namespace App\Models{
/**
 * App\Models\Employee
 *
 * @property int $id
 * @property string $name
 * @property string|null $position
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Employee defaultSort(string $column, string $direction = 'asc')
 * @method static \Database\Factories\EmployeeFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee filters(?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee filtersApply(iterable $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Employee filtersApplySelection($selection)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee query()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereUpdatedAt($value)
 */
	class IdeHelperEmployee {}
}

namespace App\Models{
/**
 * App\Models\FuelTransaction
 *
 * @property int $id
 * @property string $transaction_type
 * @property string $fuel_type
 * @property int $quantity
 * @property int $source_id
 * @property int|null $truck_id
 * @property string $consumer_type
 * @property int|null $price
 * @property int $operator_id
 * @property string|null $comment
 * @property \Illuminate\Support\Carbon $datetime
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Employee $operator
 * @property-read \App\Models\Truck|null $truck
 * @method static \Illuminate\Database\Eloquent\Builder|FuelTransaction defaultSort(string $column, string $direction = 'asc')
 * @method static \Database\Factories\FuelTransactionFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|FuelTransaction filters(?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|FuelTransaction filtersApply(iterable $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder|FuelTransaction filtersApplySelection($selection)
 * @method static \Illuminate\Database\Eloquent\Builder|FuelTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FuelTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FuelTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|FuelTransaction whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FuelTransaction whereConsumerType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FuelTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FuelTransaction whereDatetime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FuelTransaction whereFuelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FuelTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FuelTransaction whereOperatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FuelTransaction wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FuelTransaction whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FuelTransaction whereSourceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FuelTransaction whereTransactionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FuelTransaction whereTruckId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FuelTransaction whereUpdatedAt($value)
 */
	class IdeHelperFuelTransaction {}
}

namespace App\Models{
/**
 * App\Models\Journey
 *
 * @property int $id
 * @property int $employee_id
 * @property \Illuminate\Support\Carbon $date_from
 * @property \Illuminate\Support\Carbon $date_to
 * @property string|null $comment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Employee $employee
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\JourneyTransaction[] $transactions
 * @property-read int|null $transactions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Trip[] $trips
 * @property-read int|null $trips_count
 * @method static \Illuminate\Database\Eloquent\Builder|Journey defaultSort(string $column, string $direction = 'asc')
 * @method static \Database\Factories\JourneyFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Journey filters(?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Journey filtersApply(iterable $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Journey filtersApplySelection($selection)
 * @method static \Illuminate\Database\Eloquent\Builder|Journey newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Journey newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Journey query()
 * @method static \Illuminate\Database\Eloquent\Builder|Journey whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Journey whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Journey whereDateFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Journey whereDateTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Journey whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Journey whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Journey whereUpdatedAt($value)
 */
	class IdeHelperJourney {}
}

namespace App\Models{
/**
 * App\Models\JourneyTransaction
 *
 * @property int $id
 * @property int $journey_id
 * @property string $name
 * @property int $amount
 * @property string|null $comment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Journey $journey
 * @method static \Illuminate\Database\Eloquent\Builder|JourneyTransaction defaultSort(string $column, string $direction = 'asc')
 * @method static \Database\Factories\JourneyTransactionFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|JourneyTransaction filters(?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|JourneyTransaction filtersApply(iterable $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder|JourneyTransaction filtersApplySelection($selection)
 * @method static \Illuminate\Database\Eloquent\Builder|JourneyTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JourneyTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JourneyTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|JourneyTransaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JourneyTransaction whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JourneyTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JourneyTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JourneyTransaction whereJourneyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JourneyTransaction whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JourneyTransaction whereUpdatedAt($value)
 */
	class IdeHelperJourneyTransaction {}
}

namespace App\Models{
/**
 * App\Models\Locality
 *
 * @property int $id
 * @property string $region
 * @property string|null $district
 * @property string $name
 * @property string|null $longitude
 * @property string|null $latitude
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Locality defaultSort(string $column, string $direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Locality filters(?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Locality filtersApply(iterable $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Locality filtersApplySelection($selection)
 * @method static \Illuminate\Database\Eloquent\Builder|Locality newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Locality newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Locality query()
 * @method static \Illuminate\Database\Eloquent\Builder|Locality whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Locality whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Locality whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Locality whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Locality whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Locality whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Locality whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Locality whereUpdatedAt($value)
 */
	class IdeHelperLocality {}
}

namespace App\Models{
/**
 * App\Models\Trip
 *
 * @property int $id
 * @property int|null $journey_id
 * @property int $client_id
 * @property int|null $employee_id
 * @property int|null $truck_id
 * @property int $locality_from_id
 * @property int $locality_to_id
 * @property string $payment_status
 * @property string $delivery_status
 * @property int|null $distance
 * @property int|null $fuel_remains
 * @property \Illuminate\Support\Carbon|null $start_time
 * @property \Illuminate\Support\Carbon|null $finish_time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Client $client
 * @property-read \App\Models\Employee|null $employee
 * @property-read \App\Models\Journey|null $journey
 * @property-read \App\Models\Locality $localityFrom
 * @property-read \App\Models\Locality $localityTo
 * @property-read \App\Models\Truck|null $truck
 * @method static \Illuminate\Database\Eloquent\Builder|Trip defaultSort(string $column, string $direction = 'asc')
 * @method static \Database\Factories\TripFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip filters(?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip filtersApply(iterable $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Trip filtersApplySelection($selection)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Trip newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Trip query()
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereDeliveryStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereDistance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereFinishTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereFuelRemains($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereJourneyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereLocalityFromId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereLocalityToId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereTruckId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereUpdatedAt($value)
 */
	class IdeHelperTrip {}
}

namespace App\Models{
/**
 * App\Models\Truck
 *
 * @property int $id
 * @property string $name
 * @property string $number
 * @property string $status
 * @property int|null $employee_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Employee|null $employee
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FuelTransaction[] $fuelTransactions
 * @property-read int|null $fuel_transactions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Trip[] $trips
 * @property-read int|null $trips_count
 * @method static \Illuminate\Database\Eloquent\Builder|Truck defaultSort(string $column, string $direction = 'asc')
 * @method static \Database\Factories\TruckFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Truck filters(?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Truck filtersApply(iterable $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Truck filtersApplySelection($selection)
 * @method static \Illuminate\Database\Eloquent\Builder|Truck newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Truck newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Truck query()
 * @method static \Illuminate\Database\Eloquent\Builder|Truck whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Truck whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Truck whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Truck whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Truck whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Truck whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Truck whereUpdatedAt($value)
 */
	class IdeHelperTruck {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property array|null $permissions
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Orchid\Platform\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder|User averageByDays(string $value, $startDate = null, $stopDate = null, ?string $dateColumn = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User byAccess(string $permitWithoutWildcard)
 * @method static \Illuminate\Database\Eloquent\Builder|User byAnyAccess($permitsWithoutWildcard)
 * @method static \Illuminate\Database\Eloquent\Builder|User countByDays($startDate = null, $stopDate = null, ?string $dateColumn = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User countForGroup(string $groupColumn)
 * @method static \Illuminate\Database\Eloquent\Builder|User defaultSort(string $column, string $direction = 'asc')
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User filters(?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User filtersApply(iterable $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User filtersApplySelection($selection)
 * @method static \Illuminate\Database\Eloquent\Builder|User maxByDays(string $value, $startDate = null, $stopDate = null, ?string $dateColumn = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User minByDays(string $value, $startDate = null, $stopDate = null, ?string $dateColumn = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User sumByDays(string $value, $startDate = null, $stopDate = null, ?string $dateColumn = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User valuesByDays(string $value, $startDate = null, $stopDate = null, string $dateColumn = 'created_at')
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePermissions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class IdeHelperUser {}
}

