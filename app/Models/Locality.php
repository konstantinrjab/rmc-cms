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

    public const REGIONS = [
        'Cherkasy Oblast',
        'Chernihiv Oblast',
        'Chernivtsi Oblast',
        'Dnipropetrovsk Oblast',
        'Donetsk Oblast',
        'Ivano-Frankivsk Oblast',
        'Kharkiv Oblast',
        'Kherson Oblast',
        'Khmelnytskyi Oblast',
        'Kyiv Oblast',
        'Kirovohrad Oblast',
        'Luhansk Oblast',
        'Lviv Oblast',
        'Mykolaiv Oblast',
        'Odessa Oblast',
        'Poltava Oblast',
        'Rivne Oblast',
        'Sumy Oblast',
        'Ternopil Oblast',
        'Vinnytsia Oblast',
        'Volyn Oblast',
        'Zakarpattia Oblast',
        'Zaporizhzhia Oblast',
        'Zhytomyr Oblast',
    ];

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
