<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/**
 * @mixin IdeHelperEmployee
 */
class Employee extends Model
{
    use HasFactory, AsSource, Attachable, Filterable;

    public const STATUS_OK = 'ok';
    public const STATUS_ILL = 'ill';
    public const STATUS_FIRED = 'fired';

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
}
