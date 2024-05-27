<?php

namespace App\Http\Resources\api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\BookReviewRateResource;

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
            'review_id' => $this->review->id,
            'book' => $this->load('book')->book,
            'rate' => $this->review->rate,
            'content'  => $this->review->content,
            'state' => $this->review->state,
            'reviewrates' => BookReviewRateResource::collection($this->reviewRates),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
