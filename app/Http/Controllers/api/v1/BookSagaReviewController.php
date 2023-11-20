<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\BookSagaReview;
use Illuminate\Http\Request;
use App\Models\BookSaga;
use App\Http\Requests\api\v1\SagaReviewStoreRequest;
use App\Http\Requests\api\v1\SagaReviewUpdateRequest;
use App\Http\Resources\api\SagaReviewResource;

class BookSagaReviewController extends Controller
{
    public function index()
    {
        $bookSagaReviews = BookSagaReview::with('user', 'bookSaga')->orderBy('id', 'asc')->get();

        return response()->json(['bookSagaReviews' => SagaReviewResource::collection($bookSagaReviews)], 200);
    }

    public function indexByBookSaga(string $bookSaga){
        $bookSaga=BookSaga::find($bookSaga);
        if(!$bookSaga){
            return response()->json(['message'=>'book saga not found'],404);
        }

        $bookSaga->load('reviews');
        return response()->json(['reviews'=>$bookSaga->reviews],200);

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
        return response()->json(['bookSagaReview' => new SagaReviewResource($bookSagaReview)], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SagaUpdateRequest $request, BookSagaReview $bookSagaReview)
    {
    
        $bookSagaReview->update($request->except(['state', 'user_id', 'bookSaga_id']));
        $bookSagaReview->load('user', 'bookSaga', 'reviewSagaRates');

        return response()->json(['bookSagaReview' => new SagaReviewResource($bookSagaReview)], 200);
    }

    public function publish(Request $request, BookSagaReview $review)
    {
        $review->state = 'published';
        $review->save();
        return response()->json(['review' =>new  SagaReviewResource($review)]);
    }

    public function occult(Request $request, BookSagaReview $review)
    {
        $review->state = 'hidden';
        $review->save();
        return response()->json(['review' => new  SagaReviewResource($review)]);
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
