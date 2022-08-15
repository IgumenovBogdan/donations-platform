<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ContributorDonationHistoryResource extends JsonResource
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
            'id' => $this->pivot->id,
            'organization' => $this->organization->name,
            'name' => $this->name,
            'total_sent' => $this->pivot->total_sent,
            'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $this->pivot->payed_at)->format('Y.m.d H:i:s')
        ];
    }
}
