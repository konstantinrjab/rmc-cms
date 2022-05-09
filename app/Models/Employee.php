<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/**
 * @mixin IdeHelperEmployee
 */
class Employee extends Model
{
    use HasFactory, AsSource, Attachable, Filterable;

    public const STATUS_OK = 'Ok';
    public const STATUS_ILL = 'Ill';
    public const STATUS_FIRED = 'Fired';

    protected $fillable = [
        'name',
        'position',
        'status',
    ];

    /**
     * Name of columns to which http sorting can be applied
     *
     * @var array
     */
    protected $allowedSorts = [
        'name',
        'position',
        'status',
    ];

    protected $allowedFilters = [
        'name',
        'position',
        'status',
    ];

    public function truck(): HasOne
    {
        return $this->hasOne(Truck::class);
    }

    public function trips(): HasMany
    {
        return $this->hasMany(Trip::class);
    }
}
