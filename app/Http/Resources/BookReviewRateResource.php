<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookReviewRateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id' => $this->id,
            'book_review' => $this->load('bookReview'),
            'review_rate' => $this->load('reviewRate'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
