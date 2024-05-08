<?php

namespace App\Http\Resources\api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\BookReviewRate;
use App\Models\SagaReviewRate;

class ReviewRateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $formattedReviewRate =[
           'code'=>$this->id,
            'user' => $this->whenLoaded('user'),
           'value' => $this->value,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
        if ($this->isbook()) {
            $review = BookReviewRate::query()->where('reviewRate_id', $this->id)->first();
            $review->load('bookReview');
            $formattedReviewRate['bookReview'] = $review->bookReview->load('book','review');
        }
    
        if ($this->isSaga()) {
            $review = SagaReviewRate::query()->where('reviewRate_id', $this->id)->first();
            $review->load('bookSagaReview');
            $formattedReviewRate['bookSagaReview'] = $review->bookSagaReview->load('bookSaga', 'review');
        }
        return $formattedReviewRate;
    }
}
