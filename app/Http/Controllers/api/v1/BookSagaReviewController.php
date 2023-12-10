<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\v1\SagaReviewUpdateRequest;
use App\Models\BookSagaReview;
use Illuminate\Http\Request;
use App\Models\BookSaga;
use App\Models\RegisteredUser;
use App\Http\Requests\api\v1\SagaReviewStoreRequest;
use App\Http\Resources\api\SagaReviewResource;
use App\Models\Review;

class BookSagaReviewController extends Controller
{
 
        public function indexByBookSaga( BookSaga $bookSaga)
    {
        if (!$bookSaga) {
            return response()->json(['message' => 'book saga not found'], 404);
        }
        $bookReviews = BookSagaReview::with('bookSaga', 'reviewSagaRates')->orderBy('id', 'asc')->get();
      
        $publishedReviews = $bookReviews->filter(function ($review) use ($bookSaga){
            return  $review->bookSaga_id == $bookSaga->id && $review->review->state === 'published';
        });
        return response()->json(['sagaReviews' => SagaReviewResource::collection($publishedReviews)], 200);
    }
    

    public function indexBookSagaReviews()
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['message' => 'user not found'], 404);
        }
        $registeredUser = RegisteredUser::query()->where('user_id', $user['id'])->first();
        $registeredUser->load('sagaReviews');
        return response()->json(['reviews' => $registeredUser->sagaReviews], 200);
    }

    public function indexByBookSagaAdmin( BookSaga $bookSaga)
    {
        if (!$bookSaga) {
            return response()->json(['message' => 'book saga not found'], 404);
        }
        $bookReviews = BookSagaReview::with('bookSaga', 'reviewSagaRates')->orderBy('id', 'asc')->get();
      
        $publishedReviews = $bookReviews->filter(function ($review) use ($bookSaga){
            return  $review->bookSaga_id == $bookSaga->id ;
        });
        return response()->json(['sagaReviews' => SagaReviewResource::collection($publishedReviews)], 200);
    }

    public function show(string $bookSaga)
    {
        $bookSaga = BookSaga::find($bookSaga);
        if (!$bookSaga) {
            return response()->json(['message' => 'book saga not found'], 404);
        }

        $bookSaga->load('reviews');

        $publishedReviews = $bookSaga->reviews->filter(function ($review) {
            return $review->state === 'published';
        });
        return response()->json(['reviews' => $publishedReviews], 200);
    }

    



    /**
     * Store a newly created resource in storage.
     */
    public function store(SagaReviewStoreRequest $request, string $bookSaga)
    {
       
        $user = auth()->user();
        $registeredUser = RegisteredUser::query()->where('user_id', $user['id'])->first();
       // validar si el usuario ya hizo una review de esta saga 
        $bookSagaReview = BookSagaReview::where('bookSaga_id', $bookSaga)->where('user_id', $registeredUser->id)->first();
        if ($bookSagaReview) {
            return response()->json(['message' => 'user already made a review of this saga'], 400);
        }
        $data = [
            'content' => $request->input('content'),
            'rate' => $request->input('rate'),
            'user_id' => $registeredUser->id,
        ];
        $review = Review::create($data);
        $data = [
            'bookSaga_id' => $bookSaga,
            'review_id' => $review->id,
        ];
        $bookSagaReview = BookSagaReview::create($data);
        $bookSagaReview->load(['reviewSagaRates', 'bookSaga', 'user']);

        return response()->json(['sagaReview' => new SagaReviewResource($bookSagaReview)], 201);
    }

  


  


   


  

}
