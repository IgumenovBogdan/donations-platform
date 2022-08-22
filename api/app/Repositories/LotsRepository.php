<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Http\Requests\SearchLotRequest;
use App\Models\Lot;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class LotsRepository
{
    public function getAll(SearchLotRequest $request): Collection
    {
        return Lot::whereHas('organization', function (Builder $q) use ($request) {
            $q->where('name', 'LIKE', $request->query('s') . "%" ?? '');
        })->orderBy('created_at', $request->query('order') ?? 'ASC')
            ->take($request->query('take') * 10)
            ->with('organization')
            ->get();
    }
}
