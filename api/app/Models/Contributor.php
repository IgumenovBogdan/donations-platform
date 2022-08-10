<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Contributor extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'user_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lots(): BelongsToMany
    {
        return $this->belongsToMany(Lot::class)->withPivot('total_sent', 'created_at', 'id');
    }

    public function getFullName(): string
    {
        return $this->first_name . ' ' . $this->middle_name . ' ' . $this->last_name;
    }
}
