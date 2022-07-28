<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LotResource extends JsonResource
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
            'id' => $this->id,
            'organization_id' => $this->organization_id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'total_collected' => $this->total_collected
        ];
    }
}
