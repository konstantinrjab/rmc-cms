<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/**
 * @mixin IdeHelperTrip
 */
class Trip extends Model
{
    use HasFactory, AsSource, Attachable, Filterable;

    protected $fillable = [
        'client_id',
        'employee_id',
        'truck_id',
        'locality_from_id',
        'locality_to_id',
        'status',
        'mileage',
        'fuel_remains',
        'fuel_refill',
        'start_time',
        'finish_time',
    ];

    protected $casts = [
        'start_time'  => 'datetime',
        'finish_time' => 'datetime',
    ];

    /**
     * Name of columns to which http sorting can be applied
     *
     * @var array
     */
    protected $allowedSorts = [
        'client_id',
        'employee_id',
        'truck_id',
        'locality_from_id',
        'locality_to_id',
        'status',
        'mileage',
        'fuel_remains',
        'fuel_refill',
        'start_time',
        'finish_time',
    ];

    protected $allowedFilters = [
        'client_id',
        'employee_id',
        'truck_id',
        'locality_from_id',
        'locality_to_id',
        'status',
        'mileage',
        'fuel_remains',
        'fuel_refill',
        'start_time',
        'finish_time',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function truck(): BelongsTo
    {
        return $this->belongsTo(Truck::class);
    }

    public function localityFrom(): BelongsTo
    {
        return $this->belongsTo(Locality::class, 'locality_from_id');
    }

    public function localityTo(): BelongsTo
    {
        return $this->belongsTo(Locality::class, 'locality_to_id');
    }
}
