<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contributor extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'user_id',
        'settings'
    ];

    protected $casts = ["settings" => "array"];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lots(): BelongsToMany
    {
        return $this->belongsToMany(Lot::class)->withPivot('total_sent', 'payed_at', 'id');
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function getFullName(): string
    {
        return $this->first_name . ' ' . $this->middle_name . ' ' . $this->last_name;
    }
}
