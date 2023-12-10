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

        $formattedReview['likes'] = $this->countLikes()['likes'];
        $formattedReview['dislikes'] = $this->countLikes()['dislikes'];

        return $formattedReview;
    }

    public function countLikes ()
    {
       $reviewRates = null;
       if ($this->isbook()){
        $reviewRates = BookReview::query()->where('review_id', $this->id);

        $reviewRates = BookReview::query()->where('review_id', $this->id);

     $likes=   $reviewRates->whereHas('reviewRates', function ($query) {
            $query->whereHas('reviewRate', function ($q) {
                $q->where('value', 1);
            });
        });

    $dislikes = $reviewRates->whereHas('reviewRates', function ($query) {
            $query->whereHas('reviewRate', function ($q) {
                $q->where('value', 0);
            });
        });
        
  
       } else{
        $reviewRates = BookSagaReview::query()->where('review_id', $this->id);

      $likes =  $reviewRates->whereHas('reviewSagaRates', function ($query) {
            $query->whereHas('reviewRate', function ($q) {
                $q->where('value', 1);
            });
        });
        
    $dislikes = $reviewRates->whereHas('reviewSagaRates', function ($query) {
            $query->whereHas('reviewRate', function ($q) {
                $q->where('value', 0);
            });
        });
       }
     
        return [
            'likes' => $likes->count(),
            'dislikes' => $dislikes->count(),
        ];
    }

        
        
      
        
    //     $reviewRates->whereHas('reviewSagaRates', function ($query) {
    //         $query->count('value', 1);
    //     });
    


}
