<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LotStatisticsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'lot_info' => new LotResource($this),
            'latest_donations' => LotDonationsHistoryResource::collection($this->contributors()->orderBy('contributor_lot.payed_at', 'desc')->paginate(10))
        ];
    }
}
