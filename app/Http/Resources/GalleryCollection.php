<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GalleryCollection extends JsonResource
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
            'description' => $this->description,
            'category' => $this->category,
            'tags' => $this->tags,
            'alt' => $this->alt,
            'image' => $this->image,
            'image_thumb' => $this->image_thumb,
            'orientation' => $this->orientation,
            'height' => $this->height,
            'width' => $this->width,
            'order' => $this->order,
            'created_at' => $this->created_at,
        ];
    }
}
