<?php

namespace App\Http\Resources;

use App\Http\Helpers\StringHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'ceo' => StringHelper::nullStrToNull($this->ceo),
            'registration_number' => StringHelper::nullStrToNull($this->registration_number),
            'address' => StringHelper::nullStrToNull($this->address),
            'phone' => StringHelper::nullStrToNull($this->phone),
            'phone_website' => StringHelper::nullStrToNull($this->phone_website),
            'email' => StringHelper::nullStrToNull($this->email),
            'website' => StringHelper::nullStrToNull($this->website),
            'about_us' => StringHelper::nullStrToNull($this->about_us),
            'socials' => StringHelper::nullStrToNull($this->socials),
            'members' => StringHelper::nullStrToNull($this->members),
            'logo' => StringHelper::nullStrToNull($this->logo),
            'meta' => StringHelper::nullStrToNull($this->meta),
        ];
    }
}
