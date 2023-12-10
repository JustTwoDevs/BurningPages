<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\SagaReviewRate;
use App\Models\BookSagaReview;
use Illuminate\Http\Request;
use App\Http\Requests\api\v1\SagaReviewRatesStoreRequest;
use App\Http\Requests\api\v1\SagaReviewRateUpdateRequest;
use App\Http\Resources\api\SagaReviewRateResource;
use App\Http\Resources\api\SagaReviewResource;
use App\Models\RegisteredUser;
use App\Models\ReviewRate;


class SagaReviewRateController extends Controller
{
   
    
    public function indexByReview(string $review){
        $review = BookSagaReview::find($review);
        if (!$review) {
            return response()->json(['message' => 'review not found'], 404);
        }
        $reviewRates = SagaReviewRate::with('bookSagaReview', 'reviewRate')->orderBy('id', 'asc')->get();
        $reviewRates = $reviewRates->filter(function ($reviewRate) use ($review){
            return  $reviewRate->bookSagaReview_id == $review->id;
        });
        return response()->json(['reviewRates' => SagaReviewRateResource::collection($reviewRates)], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SagaReviewRatesStoreRequest $request, string $bookSagaReviewId)
    {
        $user = auth()->user();
        $registeredUser = RegisteredUser::query()->where('user_id', $user['id'])->first();
        // si ya existe una reviewrate de este usuario para esta review, no se le permite crear otro
        $bookSagaReviewRate = SagaReviewRate::with('bookSagaReview', 'reviewRate')->orderBy('id', 'asc')->get();
        $bookSagaReviewRate = $bookSagaReviewRate->filter(function ($review) use ($bookSagaReviewId, $registeredUser){
            return  $review->bookSagaReview_id == $bookSagaReviewId && $review->reviewRate->user_id == $registeredUser->id;
        });
        if ($bookSagaReviewRate->count() > 0) {
            return response()->json(['message' => 'user already has a review rate for this review'], 400);
        }
        $data = [
            'value' => $request->input('value'),
            'user_id' => $registeredUser->id,
        ];
        $reviewRate = ReviewRate::create($data);
        $data = [
            'bookSagaReview_id' => $bookSagaReviewId,
            'reviewRate_id' => $reviewRate->id,
        ];
        $bookSagaReviewRate = SagaReviewRate::create($data);
        $bookSagaReviewRate->load('bookSagaReview.review.user', 'reviewRate');
        $user = $bookSagaReviewRate->bookSagaReview->review->user;
        if ($bookSagaReviewRate->reviewRate->value != null) {
            $user->likeDifference = $user->likeDifference = $bookSagaReviewRate->reviewRate->value == 1 ? $user->likeDifference + 1 : $user->likeDifference - 1;
            $user->save();
        }

        return response()->json(['bookSagaReview' => new SagaReviewRateResource($bookSagaReviewRate)], 201);
    }

    

}
