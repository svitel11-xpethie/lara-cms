<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'ceo' => $this->ceo,
            'registration_number' => $this->registration_number,
            'address' => $this->address,
            'phone' => $this->phone,
            'email' => $this->email,
            'website' => $this->website,
            'about_us' => $this->about_us,
            'socials' => $this->socials,
            'members' => $this->members,
            'logo' => $this->logo,
            'meta' => $this->meta,
        ];
    }
}
