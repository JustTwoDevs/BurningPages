<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\BookSagaReview;
use Illuminate\Http\Request;
use App\Models\BookSaga;
use App\Models\RegisteredUser;
use App\Http\Requests\api\v1\SagaReviewStoreRequest;
use App\Http\Requests\api\v1\SagaReviewUpdateRequest;
use App\Http\Resources\api\SagaReviewResource;

class BookSagaReviewController extends Controller
{
    public function index()
    {
        
        $bookSagaReviews = BookSagaReview::with('user', 'bookSaga')->orderBy('id', 'asc')->get();
        $publishedReviews = $bookSagaReviews->filter(function ($review) {
            return $review->state === 'published'; 
        });
        return response()->json(['bookSagaReviews' => SagaReviewResource::collection($publishedReviews)], 200);
    }
    public function registeredIndex()
    {
        $bookSagaReviews = BookSagaReview::with('user', 'bookSaga')->orderBy('id', 'asc')->get();

        return response()->json(['bookSagaReviews' => SagaReviewResource::collection($bookSagaReviews)], 200);
    }

    public function indexByBookSagaRegistered(string $bookSaga){
        $bookSaga=BookSaga::find($bookSaga);
        if(!$bookSaga){
            return response()->json(['message'=>'book saga not found'],404);
        }

        $bookSaga->load('reviews');
        return response()->json(['reviews'=>$bookSaga->reviews],200);
    }

    public function indexByBookSaga(string $bookSaga){
        $bookSaga=BookSaga::find($bookSaga);
        if(!$bookSaga){
            return response()->json(['message'=>'book saga not found'],404);
        }

        $bookSaga->load('reviews');
        $publishedReviews = $bookSaga->reviews->filter(function ($review) {
            return $review->state === 'published'; 
        });
        return response()->json(['reviews'=>$publishedReviews],200);
    }

    public function indexByUser(string $user){
        $user=RegisteredUser::find($user);
        if(!$user){
            return response()->json(['message'=>'user not found'],404);
        }

        $user->load('sagaReviews');
        $publishedReviews = $user->sagaReviews->filter(function ($sagaReview) {
            return $sagaReview->state === 'published'; 
        });
        return response()->json(['reviews'=>$publishedReviews],200);
    }

    public function indexByUserRegistered(string $user){
        $user=RegisteredUser::find($user);
        if(!$user){
            return response()->json(['message'=>'user not found'],404);
        }

        $user->load('sagaReviews');
        
        return response()->json(['reviews'=>$user->sagaReviews],200);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(SagaReviewStoreRequest $request)
    {
        $bookSagaReview = BookSagaReview::create($request->except('state'));
        $bookSagaReview->load('user', 'bookSaga', 'reviewSagaRates');
        return response()->json(['bookSagaReview' => new SagaReviewResource($bookSagaReview)], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(BookSagaReview $bookSagaReview)
    {
        $bookSagaReview->load('user', 'bookSaga', 'reviewSagaRates');
        if($bookSagaReview->state==='published'){
            return response()->json(['bookSagaReview' => new SagaReviewResource($bookSagaReview)], 200);
        }
       return response()->json(['message'=>'review not found'],404);
    }

    public function showRegistered(BookSagaReview $bookSagaReview)
    {
        $bookSagaReview->load('user', 'bookSaga', 'reviewSagaRates');
      
            return response()->json(['bookSagaReview' => new SagaReviewResource($bookSagaReview)], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SagaReviewUpdateRequest $request, BookSagaReview $bookSagaReview)
    {
    
        $bookSagaReview->update($request->except(['state', 'user_id', 'bookSaga_id']));
        $bookSagaReview->load('user', 'bookSaga', 'reviewSagaRates');

        return response()->json(['bookSagaReview' => new SagaReviewResource($bookSagaReview)], 200);
    }

    public function publishAdmin(Request $request, BookSagaReview $review)
    {
        if ($review->state === 'hidden') {
            $review->state = 'published';
        $review->save();
        return response()->json(['review' =>new  SagaReviewResource($review)]);
        }
        return response()->json(['message' => 'the review is not occult'], 400);
       
    }
    public function publishRegistered(Request $request, BookSagaReview $review)
    {
        if ($review->state === 'draft') {
            $review->state = 'published';
        $review->save();
        return response()->json(['review' =>new  SagaReviewResource($review)]);
        }
        return response()->json(['message' => 'the review is not a draft'], 400);
       
    }


    public function occult(Request $request, BookSagaReview $review)
    {
        if ($review->state === 'published') {
            $review->state = 'hidden';
            $review->save();
            return response()->json(['review' => new  SagaReviewResource($review)]);
        }
        return response()->json(['message' => 'the review is not published'], 400);
       
    }

  

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BookSagaReview $bookSagaReview)
    {
        $bookSagaReview->delete();
        return response(null, 204);
    }
}
