<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/**
 * @mixin IdeHelperJourney
 */
class Journey extends Model
{
    use HasFactory, AsSource, Attachable, Filterable;

    protected $fillable = [
        'employee_id',
        'date_from',
        'date_to',
    ];

    protected $casts = [
        'date_from' => 'datetime',
        'date_to' => 'datetime',
    ];

    /**
     * Name of columns to which http sorting can be applied
     *
     * @var array
     */
    protected $allowedSorts = [
        'employee_id',
        'date_from',
        'date_to',
    ];

    protected $allowedFilters = [
        'employee_id',
        'date_from',
        'date_to',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function trips(): HasMany
    {
        return $this->hasMany(Trip::class);
    }
}
