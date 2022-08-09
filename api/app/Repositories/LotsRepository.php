<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Lot;
use Illuminate\Pagination\LengthAwarePaginator;

class LotsRepository
{
    public function getAll(): LengthAwarePaginator
    {
        return Lot::paginate(10);
    }
}
