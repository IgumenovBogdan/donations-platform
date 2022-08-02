<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CreateLotRequest;
use App\Http\Requests\UpdateLotRequest;
use App\Http\Resources\LotResource;
use App\Models\Lot;
use App\Services\LotService;
use Illuminate\Http\JsonResponse;

class LotController extends Controller
{
    public function __construct(private readonly LotService $lotService)
    {
        $this->authorizeResource(Lot::class);
    }

    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return LotResource::collection(Lot::paginate(10));
    }

    public function store(CreateLotRequest $request): LotResource
    {
        return $this->lotService->store($request);
    }

    public function show(Lot $lot): LotResource
    {
        return new LotResource($lot);
    }

    public function update(UpdateLotRequest $request, Lot $lot): LotResource
    {
        return $this->lotService->update($lot, $request);
    }

    public function destroy(Lot  $lot): JsonResponse
    {
        return $this->lotService->destroy($lot);
    }
}
