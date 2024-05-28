<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\v1\ReviewRatesStoreRequest;
use App\Http\Resources\api\ReviewRateResource;
use App\Models\ReviewRate;
use App\Models\Review;
use App\Models\RegisteredUser;
use Illuminate\Http\Request;



class ReviewRateController extends Controller
{
    public function index()
    {
        $reviewRates = ReviewRate::with('user', 'review')->orderBy('user_id', 'asc')->get();

        return response()->json(['reviewRate' => ReviewRateResource::collection($reviewRates)], 200);
    }
    public function indexMyReviewRates()
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['message' => 'user not found'], 404);
        }
        $registeredUser = RegisteredUser::where('user_id', $user['id'])->first();

        $reviewRates = ReviewRate::with('user')->orderBy('user_id', 'asc')->get();
        $filteredRates = $reviewRates->filter(function ($reviewRate) use ($registeredUser) {
            $result = $reviewRate->user->id == $registeredUser->id;
            return $result;
        });

        return response()->json(['reviewRates' => ReviewRateResource::collection($filteredRates)], 200);
    }

    public function update(ReviewRatesStoreRequest $request, string $reviewRate)
    {
        $reviewRate = ReviewRate::find($reviewRate);
        if (!$reviewRate) {
            return response()->json(['message' => 'review rate not found'], 404);
        }
        $reviewRate->update($request->except('user_id'));
        return response()->json(['reviewRate' => new ReviewRateResource($reviewRate)], 200);
    }


    public function indexByReview(Review $review)
    {
        if (!$review) {
            return response()->json(['message' => 'review not found'], 404);
        }
        $review = Review::find($review);
        $review->load('reviewRates');
        $reviewRates = ReviewRate::with('user')->orderBy('user_id', 'asc')->get();
    }


    /**
     * Display the specified resource.
     */
    public function show(ReviewRate $reviewRate)
    {
        $reviewRate->load('user');
        return response()->json(['reviewRate' => new ReviewRateResource($reviewRate)], 200);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReviewRate $reviewRate)
    {
        $reviewRate->delete();
        return response(null, 204);
    }
}
