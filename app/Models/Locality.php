<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/**
 * @mixin IdeHelperLocality
 */
class Locality extends Model
{
    use HasFactory, AsSource, Attachable, Filterable;

    protected $fillable = [
        'region',
        'district',
        'name',
        'longitude',
        'latitude',
    ];

    /**
     * Name of columns to which http sorting can be applied
     *
     * @var array
     */
    protected $allowedSorts = [
        'region',
        'district',
        'name',
        'longitude',
        'latitude',
    ];

    protected $allowedFilters = [
        'region',
        'district',
        'name',
        'longitude',
        'latitude',
    ];
}
