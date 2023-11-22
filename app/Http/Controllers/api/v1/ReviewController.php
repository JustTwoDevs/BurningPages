<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Resources\api\GReviewResource;
use App\Http\Requests\api\v1\ReviewUpdateRequest;
use App\Models\RegisteredUser;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = Review::with('user')->orderBy('user_id', 'asc')->get();
        $publishedReviews = $reviews->filter(function ($review) {
            return $review->state === 'published';
        });

        return response()->json(['reviews' => GReviewResource::collection($publishedReviews)], 200);
    }

    public function indexMyReviews()
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['message' => 'user not found'], 404);
        }
        $user->load('reviews');
        return response()->json(['reviews' => new GReviewResource($user->reviews)], 200);
    }

    public function indexRegistered(){
        $reviews = Review::with('user')->orderBy('user_id', 'asc')->get();

        return response()->json(['reviews' => new GReviewResource($reviews)], 200);
    }

    public function publishAdmin(Request $request, Review $review)
    {
        if ($review->state === 'occult') {
            $review->state = 'published';
            $review->save();
            return response()->json(['review' => new GReviewResource($review)]);
        }
        return response()->json(['message' => 'review is not occult'], 400);
    }

    public function publishRegistered(Request $request, Review $review)
    {
        if ($review->state === 'draft') {
            $review->state = 'published';
            $review->save();
            return response()->json(['review' => new GReviewResource($review)]);
        }
        return response()->json(['message' => 'review is not a draft'], 400);
    }

    public function occult(Request $request, Review $review)
    {
        if ($review->state === 'published') {
            $review->state = 'hidden';
            $review->save();
            return response()->json(['review' => new GReviewResource($review)]);
        }
        return response()->json(['message' => 'review is not published'], 400);
    }

    public function draft( Review $review)
    {
        if ($review->state === 'published') {
            $review->state = 'draft';
            $review->save();
            return response()->json(['review' => new GReviewResource($review)]);
        }
        return response()->json(['message' => 'review is not published'], 400);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $bookReview)
    {
        $bookReview->delete();
        return response(null, 204);
    }

   


    /**
     * Display the specified resource.
     */
    public function showRegistered(Review $review)
    {
        $review->load(['reviewRates', 'user']);
        return response()->json(['review' => new GReviewResource($review)], 200);
    }

    public function update(ReviewUpdateRequest $request, Review $review)
    {
        if ($review->state !== 'draft') {
            return response()->json(['message' => 'review is not a draft'], 400);
        }
        $review->update($request->except(['state', 'user_id']));
        $review->load(['reviewRates', 'user']);

        return response()->json(['review' => new  GReviewResource($review)], 200);
    }

    public function indexByUser(Request $request, string $user)
    {
        $user = RegisteredUser::find($user);
        if (!$user) {
            return response()->json(['message' => 'user not found'], 404);
        }

        $user->load( 'reviews.user');

        $publishedReviews = $user->reviews->filter(function ($review) {
            return $review->state === 'published';
        });

        return response()->json(['reviews' => $publishedReviews], 200);
    }

    public function indexByUserAdmin(Request $request, string $user)
    {
        $user = RegisteredUser::find($user);
        if (!$user) {
            return response()->json(['message' => 'user not found'], 404);
        }

        $user->load('reviews.user');

        return response()->json(['reviews' => $user->reviews], 200);
    }


   
}
