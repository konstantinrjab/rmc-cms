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

    public const DELIVERY_STATUS_ORDERED = 'ordered';
    public const DELIVERY_STATUS_IN_PROGRESS = 'in progress';
    public const DELIVERY_STATUS_DONE = 'done';

    public const PAYMENT_STATUS_PAYED = 'payed';
    public const PAYMENT_STATUS_INVOICE_SENT = 'invoice sent';
    public const PAYMENT_STATUS_NO_INVOICE = 'no invoice';
    public const PAYMENT_STATUS_NOT_NEEDED = 'not needed';

    protected $fillable = [
        'journey_id',
        'client_id',
        'employee_id',
        'truck_id',
        'locality_from_id',
        'locality_to_id',
        'delivery_status',
        'payment_status',
        'income',
        'distance',
        'fuel_remains',
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
        'journey_id',
        'client_id',
        'employee_id',
        'truck_id',
        'locality_from_id',
        'locality_to_id',
        'delivery_status',
        'payment_status',
        'income',
        'distance',
        'fuel_remains',
        'start_time',
        'finish_time',
    ];

    protected $allowedFilters = [
        'journey_id',
        'client_id',
        'employee_id',
        'truck_id',
        'locality_from_id',
        'locality_to_id',
        'delivery_status',
        'payment_status',
        'income',
        'distance',
        'fuel_remains',
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

    public function journey(): BelongsTo
    {
        return $this->belongsTo(Journey::class);
    }
}
