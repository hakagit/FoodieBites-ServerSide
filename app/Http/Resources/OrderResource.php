<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'name' => $this->name,
            'date' => $this->date,
            'user_id' => $this->user_id,
            'driver_id' => $this->driver_id,
            'user' => new UserResource($this->whenLoaded('user')), // Include user relationship if loaded
            'driver' => new DriverResource($this->whenLoaded('driver')), // Include driver relationship if loaded
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
