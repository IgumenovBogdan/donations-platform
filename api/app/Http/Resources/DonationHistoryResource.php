<?php

namespace App\Http\Resources;

use App\Models\Organization;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class DonationHistoryResource extends JsonResource
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
            'total_sent' => $this->pivot->sent,
            'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $this->pivot->created_at)->format('Y.m.d H:i:s')
        ];
    }
}
