<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CreateLotRequest;
use App\Http\Requests\UpdateLotRequest;
use App\Http\Resources\LotDonationsHistoryResource;
use App\Http\Resources\LotResource;
use App\Http\Resources\LotStatisticsResource;
use App\Models\Lot;
use App\Repositories\DonationsRepository;
use App\Repositories\LotsRepository;
use App\Services\LotService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class LotController extends Controller
{
    public function __construct(
        private readonly LotService $lotService,
        private readonly LotsRepository $lotsRepository,
        private readonly DonationsRepository $donationsRepository
    )
    {}

    public function index(): AnonymousResourceCollection
    {
        return LotResource::collection($this->lotsRepository->getAll());
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
        $this->authorize('owner', $lot);
        return $this->lotService->update($request, $lot);
    }

    public function destroy(Lot $lot): JsonResponse
    {
        return $this->lotService->destroy($lot);
    }

    public function getLotDonationHistory(Lot $lot): AnonymousResourceCollection
    {
        $this->authorize('owner', $lot);
        return LotDonationsHistoryResource::collection($this->donationsRepository->getAllLotHistory($lot));
    }

    public function getLotStatistics(Lot $lot): LotStatisticsResource
    {
        return new LotStatisticsResource($lot);
    }
}
