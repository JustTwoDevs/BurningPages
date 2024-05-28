<?php

namespace App\Http\Resources\api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'code' => $this->id,
            'user' => $this->review->user,
            'book' => $this->load('book')->book,
            'rate' => $this->review->rate,
            'content'  => $this->review->content,
            'state' => $this->review->state,
            'reviewrates' => $this->load('reviewRates'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            
        ];
    }
}
