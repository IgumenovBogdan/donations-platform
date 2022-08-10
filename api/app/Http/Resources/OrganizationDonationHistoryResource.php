<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class OrganizationDonationHistoryResource extends JsonResource
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
            'contributor' => $this->getFullName(),
            'total_sent' => $this->pivot->total_sent,
            'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $this->pivot->created_at)->format('Y.m.d H:i:s')
        ];
    }
}
