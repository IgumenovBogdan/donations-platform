<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubscriptionHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscription_id',
        'payed_at'
    ];

    public $timestamps = false;

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }
}
