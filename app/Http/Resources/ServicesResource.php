<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ServicesResource extends JsonResource
{
    public static $wrap = null; // Disable wrapping for this resource only

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'slug' => $this->slug,
            'description' => Str::limit($this->content, 200),
            'image' => $this->image,
            'image_thumb' => $this->image_thumb,
            'order' => $this->order,
            'views' => $this->views,
            'meta_tags' => $this->meta_tags,
            'meta_data' => $this->meta_data,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
