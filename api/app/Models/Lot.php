<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lot extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'total_collected',
        'organization_id'
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

}
