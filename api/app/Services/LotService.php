<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Resources\LotResource;
use App\Models\Lot;

class LotService
{
    public function store($request): LotResource
    {
        $lot = Lot::create(array_merge(
            $request->only('name', 'description', 'price'),
            [
                'organization_id' => auth()->user()->organization->id,
                'total_collected' => 0
            ]
        ));
        return new LotResource($lot);
    }

    public function update($lot, $request): LotResource
    {
        $lot->update($request->only('name', 'description', 'price'));
        return new LotResource($lot);
    }

    public function destroy($lot)
    {
        return response()->json([
            'data' => $lot->delete()
        ]);
    }
}
