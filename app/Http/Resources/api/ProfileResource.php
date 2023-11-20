<?php

namespace App\Http\Resources\api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->user->name . ' ' . $this->user->lastname,
            'username' => $this->user->username,
            'verified' => $this->verified,
            'rank' => $this->rank,
            'nationality' => $this->user->nationality->name,
        ];
    }
}
