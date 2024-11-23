<?php

namespace App\Http\Resources;

use App\Http\Helpers\StringHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
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
            'name' => StringHelper::nullStrToNull($this->name),
            'email' => StringHelper::nullStrToNull($this->email),
            'phone' => StringHelper::nullStrToNull($this->phone),
            'description' => StringHelper::nullStrToNull($this->description),
            'photo' => StringHelper::nullStrToNull($this->photo),
            'role' => StringHelper::nullStrToNull($this->role),
            'order' => $this->order,
            'is_active' => $this->is_active,
        ];
    }
}
