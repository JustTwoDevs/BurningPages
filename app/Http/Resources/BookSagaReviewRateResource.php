<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookSagaReviewRateResource extends JsonResource
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
            'bookSagaReview_id' => $this->bookSagaReview_id,
            'review_rate' => $this->load('reviewRate', 'reviewRate.user.user'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
