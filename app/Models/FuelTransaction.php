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
    public const TYPE_PURCHASE = 'purchase';
    public const TYPE_SALE = 'sale';

    use HasFactory, AsSource, Attachable, Filterable;

    protected $fillable = [
        'transaction_type',
        'fuel_type',
        'quantity',
        'operator_id',
        'subject_id',
        'info',
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
        'operator_id',
        'subject_id',
        'datetime',
    ];

    protected $allowedFilters = [
        'transaction_type',
        'fuel_type',
        'quantity',
        'operator_id',
        'subject_id',
        'datetime',
    ];

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
