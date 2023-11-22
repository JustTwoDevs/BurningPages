<?php

namespace App\Http\Resources\api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        
        $formattedReview=[
            'code' => $this->id,
            'user' => $this->user,
            'rate' => $this->rate,
            'content'  => $this->content,
            'state' => $this->state,
          //  'reviewrates' => $this->load('reviewRates'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
        if ($this->resource instanceof \App\Models\BookReview) {
            $formattedReview['book'] = 'pude entrar';
            $formattedReview['book'] = $this->load('book');
        }

        if ($this->resource instanceof \App\Models\BookSagaReview) {
            $formattedReview['book'] = 'pude entrar';
            $formattedReview['bookSaga'] = $this->load('bookSaga');   
        }

        return $formattedReview;
    }
}
