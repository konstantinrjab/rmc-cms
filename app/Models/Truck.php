<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/**
 * @mixin IdeHelperTruck
 */
class Truck extends Model
{
    use HasFactory, AsSource, Attachable, Filterable;

    public const STATUS_OK = 'ok';
    public const STATUS_UNDER_REPAIR = 'under repair';
    public const STATUS_ON_THE_WAY = 'on the way';

    protected $fillable = [
        'name',
        'number',
        'status',
        'employee_id',
    ];

    /**
     * Name of columns to which http sorting can be applied
     *
     * @var array
     */
    protected $allowedSorts = [
        'name',
        'number',
        'status',
        'employee_id',
    ];

    protected $allowedFilters = [
        'name',
        'number',
        'status',
        'employee_id',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
