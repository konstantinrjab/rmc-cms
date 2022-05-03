<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/**
 * @mixin IdeHelperTrip
 */
class Journey extends Model
{
    use HasFactory, AsSource, Attachable, Filterable;

    protected $fillable = [
        'name'
    ];

    /**
     * Name of columns to which http sorting can be applied
     *
     * @var array
     */
    protected $allowedSorts = [
        'name'
    ];

    protected $allowedFilters = [
        'name'
    ];

    public function trips(): HasMany
    {
        return $this->hasMany(Trip::class);
    }
}
