<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/**
 * @mixin IdeHelperFuelTransaction
 */
class FuelTransaction extends Model
{
    public const TYPE_INCOME = 'income';
    public const TYPE_EXPENSE = 'expense';

    public const TYPE_OWN_STATION = 'own_station';
    public const TYPE_TRUCK = 'truck';
    public const TYPE_OTHER = 'other';

    public const TYPE_FUEL_DIESEL = 'diesel';

    public const TYPE_SOURCE_AMIC = 1;
    public const TYPE_SOURCE_TANK_FARM = 2;
    public const TYPE_SOURCE_OWN_STATION = 3;

    use HasFactory, AsSource, Attachable, Filterable;

    protected $fillable = [
        'transaction_type',
        'fuel_type',
        'quantity',
        'source_id',
        'truck_id',
        'consumer_type',
        'price',
        'operator_id',
        'comment',
        'datetime',
    ];

    protected $casts = [
        'datetime' => 'datetime'
    ];

    /**
     * Name of columns to which http sorting can be applied
     *
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'transaction_type',
        'fuel_type',
        'quantity',
        'source_id',
        'truck_id',
        'consumer_type',
        'price',
        'operator_id',
        'comment',
        'datetime',
    ];

    protected $allowedFilters = [
        'transaction_type',
        'fuel_type',
        'quantity',
        'source_id',
        'truck_id',
        'consumer_type',
        'price',
        'operator_id',
        'datetime',
    ];

    public function operator(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function truck(): BelongsTo
    {
        return $this->belongsTo(Truck::class);
    }

    public static function getSources(array $filter = null): array
    {
        $types = [
            self::TYPE_SOURCE_AMIC        => __('Amic'),
            self::TYPE_SOURCE_TANK_FARM   => __('Tank Farm'),
            self::TYPE_SOURCE_OWN_STATION => __('Own Station'),
        ];

        if ($types) {
            return Arr::only($types, $filter);
        }

        return $types;
    }
}
