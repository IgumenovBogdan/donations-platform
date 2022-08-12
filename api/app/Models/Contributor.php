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
        return $this->belongsToMany(Lot::class)->withPivot('total_sent', 'created_at', 'id');
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function setting(string $name, $default = null)
    {
        if (array_key_exists($name, $this->settings)) {
            return $this->settings[$name];
        }
        return $default;
    }

    public function settings(array $revisions, bool $save = true) : self
    {
        $this->settings = array_merge($this->settings, $revisions);
        if ($save) {
            $this->save();
        }
        return $this;
    }

    public function getFullName(): string
    {
        return $this->first_name . ' ' . $this->middle_name . ' ' . $this->last_name;
    }
}
