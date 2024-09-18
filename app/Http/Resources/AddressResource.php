<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'street' => $this->street,
            'apartment' => $this->apartment,
            'user_id' => $this->user_id,
            'user' => UserResource::collection($this->whenLoaded('user')), // Include user relationship if loaded
        ];
    }
}
