<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\CreateLotRequest;
use App\Http\Requests\UpdateLotRequest;
use App\Http\Resources\LotResource;
use App\Models\Lot;
use Illuminate\Http\JsonResponse;

class LotService
{
    public function store(CreateLotRequest $request): LotResource
    {
        $lot = Lot::create(array_merge(
            $request->only('name', 'description', 'price'),
            [
                'organization_id' => $request->user()->organization->id,
                'total_collected' => 0
            ]
        ));
        return new LotResource($lot);
    }

    public function update(UpdateLotRequest $request, Lot $lot): LotResource
    {
        $lot->update($request->only('name', 'description', 'price'));
        return new LotResource($lot);
    }

    public function destroy(Lot $lot): JsonResponse
    {
        return response()->json([
            'data' => $lot->delete()
        ]);
    }
}
