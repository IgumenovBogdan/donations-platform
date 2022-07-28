<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLotRequest;
use App\Http\Requests\UpdateLotRequest;
use App\Http\Resources\LotResource;
use App\Models\Lot;
use Illuminate\Http\JsonResponse;

class LotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return LotResource::collection(Lot::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateLotRequest $request
     * @return LotResource
     */
    public function store(CreateLotRequest $request): LotResource
    {
        $this->authorize('create', Lot::class);
        $lot = Lot::create(array_merge(
            $request->only('name', 'description', 'price'),
            [
                'organization_id' => auth()->user()->organization()->first()->id,
                'total_collected' => 0
            ]
        ));
        return new LotResource($lot);
    }

    /**
     * Display the specified resource.
     *
     * @param  Lot  $lot
     * @return LotResource
     */
    public function show(Lot $lot): LotResource
    {
        return new LotResource($lot);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateLotRequest $request
     * @param Lot $lot
     * @return LotResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateLotRequest $request, Lot $lot): LotResource
    {
        $this->authorize('update', $lot);
        $lot->update($request->only('name', 'description', 'price'));
        return new LotResource($lot);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Lot $lot
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Lot  $lot): JsonResponse
    {
        $this->authorize('delete', $lot);
        return response()->json([
            'data' => $lot->delete()
        ]);
    }
}
