<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScriptResource extends JsonResource
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
            'script' => $this->script,
            'position' => $this->position,
            'is_active' => $this->is_active,
            'image' => $this->image ?? '/assets/images/defaults/script.png',
            'order' => $this->order,
        ];
    }
}
