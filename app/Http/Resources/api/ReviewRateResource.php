<?php

namespace App\Http\Resources\api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewRateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
           'code'=>$this->id,
            'user' => $this->whenLoaded('user'),
            'review' => $this->whenLoaded('bookReview'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
