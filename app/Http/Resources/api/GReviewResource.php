<?php

namespace App\Http\Resources\api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\BookReview;
use App\Models\BookReviewRate;
use App\Models\SagaReviewRate;
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

        $formattedReview['likes'] = $this->countLikes()['likes'];
        $formattedReview['dislikes'] = $this->countLikes()['dislikes'];

        return $formattedReview;
    }

    public function countLikes()
{
    $reviewRates = null;
    $relationName = $this->isbook() ? 'reviewRates' : 'reviewSagaRates';

    $reviewRates = $this->isbook()
        ? BookReview::query()->where('review_id', $this->id)
        : BookSagaReview::query()->where('review_id', $this->id);

    $likes = $reviewRates->whereHas($relationName, function ($query) {
        $query->whereHas('reviewRate', function ($q) {
            $q->where('value', 1);
        });
    })->count();

    $dislikes = $reviewRates->whereHas($relationName, function ($query) {
        $query->whereHas('reviewRate', function ($q) {
            $q->where('value', 0);
        });
    })->count();

    return [
        'likes' => $likes,
        'dislikes' => $dislikes,
    ];
}



}
