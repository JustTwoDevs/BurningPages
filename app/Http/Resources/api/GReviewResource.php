<?php

namespace App\Http\Resources\api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\BookReview;
use App\Models\BookSagaReview;

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
            'user' => $this->load('user')->user,
            'rate' => $this->rate,
            'content'  => $this->content,
            'state' => $this->state,
          //  'reviewrates' => $this->load('reviewRates'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
        if ($this->isbook()) {
            $book = BookReview::query()->where('review_id', $this->id)->first();
            $book->load('book');
            $formattedReview['book'] = $book->book;
        }
    
        if ($this->isSaga()) {
            $bookSaga = BookSagaReview::query()->where('review_id', $this->id)->first();
            $bookSaga->load('bookSaga');
            $formattedReview['bookSaga'] = $bookSaga->bookSaga;
        }

        return $formattedReview;
    }
}
