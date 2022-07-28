<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLotRequest;
use App\Http\Resources\LotResource;
use App\Models\Lot;
use Illuminate\Http\Request;

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
    public function show(Lot $lot)
    {
        return new LotResource($lot);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
