<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CreateLotRequest;
use App\Http\Requests\UpdateLotRequest;
use App\Http\Resources\LotResource;
use App\Models\Lot;
use App\Services\LotService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class LotController extends Controller
{
    public function __construct(private readonly LotService $lotService)
    {}

    public function index(): AnonymousResourceCollection
    {
        return LotResource::collection(Lot::paginate(10));
    }

    public function store(CreateLotRequest $request): LotResource
    {
        $this->authorize('create', Lot::class);
        return $this->lotService->store($request);
    }

    public function show(Lot $lot): LotResource
    {
        return new LotResource($lot);
    }

    public function update(UpdateLotRequest $request, Lot $lot): LotResource
    {
        $this->authorize('update', $lot);
        return $this->lotService->update($request, $lot);
    }

    public function destroy(Lot $lot): JsonResponse
    {
        return $this->lotService->destroy($lot);
    }
}
