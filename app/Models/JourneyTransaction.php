<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/**
 * @mixin IdeHelperJourneyTransaction
 */
class JourneyTransaction extends Model
{
    use HasFactory, AsSource, Attachable, Filterable;

    public const INCOME = 'income';
    public const EXPENSE = 'expense';

    protected $fillable = [
        'journey_id',
        'type',
        'amount',
        'comment',
    ];

    public function journey(): BelongsTo
    {
        return $this->belongsTo(Journey::class);
    }
}
