<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    public const TYPE_OWN_STATION = 'Own Station';
    public const TYPE_TRUCK = 'Truck';
    public const TYPE_OTHER = 'Other';

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

    public static function getSources(): array
    {
        return [
            1 => __('Amic'),
            2 => __('Tank Farm'),
            3 => __('Own Station'),
        ];
    }
}
