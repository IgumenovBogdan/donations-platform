<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class LastMonthDonatesResource extends JsonResource
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
            'sent' => $this->sent,
            'company' => $this->company,
            'payed_at' => Carbon::createFromFormat('Y-m-d H:i:s', $this->payed_at)->toDateString(),
        ];
    }
}
