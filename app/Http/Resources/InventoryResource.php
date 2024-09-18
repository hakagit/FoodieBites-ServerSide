<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InventoryResource extends JsonResource
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
            'quantity' => $this->quantity,
            'expiry' => $this->expiry,
            'user_id' => $this->user_id,
            'user' => UserResource::collection($this->whenLoaded('user')), // Include user relationship if loaded
            'suppliers' => SupplierResource::collection($this->whenLoaded('suppliers')), // Include suppliers if loaded

            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
