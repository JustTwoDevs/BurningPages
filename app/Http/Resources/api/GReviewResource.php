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

        $formattedReview['likes'] = $this->countLikes();
      


        return $formattedReview;
    }

    public function countLikes ()
    {
       $reviewRates = null;
       if ($this->isbook()){
        $reviewRates = BookReview::query()->where('review_id', $this->id);
        $reviewRates->with('reviewRates');
        $reviewRates->whereHas('reviewRates', function ($query) {
            $query->with('reviewRate')
            ->whereHas('reviewRate', function ($query) {
                $query->count('value', 1);
             });
         });

       } else{
        $reviewRates = BookSagaReview::query()->where('review_id', $this->id);
        $reviewRates->with('reviewSagaRates');
        $reviewRates->whereHas('reviewSagaRates', function ($query) {
            $query->with('reviewRate')
            ->whereHas('reviewRate', function ($query) {
                $query->count('value', 1);
             });
         });
    //     $reviewRates->whereHas('reviewSagaRates', function ($query) {
    //         $query->count('value', 1);
    //     });
        }
       $reviewRates =$reviewRates->get();
        return $reviewRates;
    }


}
