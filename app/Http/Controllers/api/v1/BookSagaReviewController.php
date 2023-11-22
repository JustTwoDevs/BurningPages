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

class BookSagaReviewController extends Controller
{
   
    public function indexByBookSagaRegistered(string $bookSaga)
    {
        $bookSaga = BookSaga::find($bookSaga);
        if (!$bookSaga) {
            return response()->json(['message' => 'book saga not found'], 404);
        }

        $bookSaga->load('reviews');
        return response()->json(['reviews' => $bookSaga->reviews], 200);
    }

    public function indexMyBookSagaReviews()
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['message' => 'user not found'], 404);
        }
        $registeredUser = RegisteredUser::query()->where('user_id', $user['id'])->first();
        $registeredUser->load('sagaReviews');
        return response()->json(['reviews' => $registeredUser->sagaReviews], 200);
    }

    public function indexByBookSaga(string $bookSaga)
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
        $sagaReview = BookSagaReview::create($request->except('state'));
        $sagaReview->user_id = $registeredUser->id;
        $saga = BookSaga::find($bookSaga);
        $sagaReview->bookSaga_id = $saga->id;
        $sagaReview->load(['reviewRates', 'bookSaga', 'user']);

        return response()->json(['bookReview' => new SagaReviewResource($sagaReview)], 201);
    }

  


    /**
     * Update the specified resource in storage.
     */
    public function update(SagaReviewUpdateRequest $request, BookSagaReview $bookSagaReview)
    {
        if ($bookSagaReview->state === 'published' || $bookSagaReview->state === 'hidden') {
            return response()->json(['message' => 'the review is not a draft'], 400);
        } 

        $bookSagaReview->update($request->except(['state', 'user_id', 'bookSaga_id']));
        $bookSagaReview->load('user', 'bookSaga', 'reviewSagaRates');

        return response()->json(['bookSagaReview' => new SagaReviewResource($bookSagaReview)], 200);
    }

    public function draft( BookSagaReview $review)
    {
        if ( $review->state === 'hidden') {
            return response()->json(['message' => 'you can not turn this review a draft'], 400);
        }
        $review->state = 'draft';
        $review->save();
        return response()->json(['review' => new  SagaReviewResource($review)]);
    }

    public function publishAdmin(Request $request, BookSagaReview $review)
    {
        if ($review->state === 'hidden') {
            $review->state = 'published';
            $review->save();
            return response()->json(['review' => new  SagaReviewResource($review)]);
        }
        return response()->json(['message' => 'the review is not occult'], 400);
    }
    public function publishRegistered(Request $request, BookSagaReview $review)
    {
        if ($review->state === 'draft') {
            $review->state = 'published';
            $review->save();
            return response()->json(['review' => new  SagaReviewResource($review)]);
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
