<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationResource extends JsonResource
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
            'user_id' => $this->user_id,
            'name' => $this->name,
            'description' => $this->description,
            'phone' => $this->phone,
            'lots' => LotResource::collection($this->lots)
        ];
    }
}
