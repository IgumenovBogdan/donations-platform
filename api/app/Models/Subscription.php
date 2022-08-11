<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'tariff',
        'contributor_id',
        'organization_id',
        'subscribed_at'
    ];

    protected $dates = ['subscribed_at'];

    public $timestamps = false;

    public function contributor(): BelongsTo
    {
        return $this->belongsTo(Contributor::class);
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function history(): HasMany
    {
        return $this->hasMany(SubscriptionHistory::class);
    }
}
