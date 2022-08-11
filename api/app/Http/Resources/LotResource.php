<?php

declare(strict_types=1);

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
            'organization' => $this->organization->name,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'total_collected' => $this->total_collected,
            'total_collected_in_percent' => round($this->total_collected / $this->price * 100, 2),
            'status' => $this->is_completed ? 'Completed' : 'Not completed'
        ];
    }
}
