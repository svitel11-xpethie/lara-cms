<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CloudResource extends JsonResource
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
            'image' => $this->image,
            'image_thumb' => $this->image_thumb,
            'type' => $this->type,
            'size' => $this->size,
            'orientation' => $this->orientation,
            'created_at' => $this->created_at,
        ];
    }
}
