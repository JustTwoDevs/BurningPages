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
        $review=BookSagaReview::find($review);
        if(!$review){
            return response()->json(['message'=>'review not found'],404);
        }

        $review->load('reviewSagaRates');
        return response()->json(['sagaReviewRates'=>$review->reviewSagaRates],200);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SagaReviewRatesStoreRequest $request, string $bookSagaReviewId)
    {
        $user = auth()->user();
        $registeredUser = RegisteredUser::query()->where('user_id', $user['id'])->first();
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
      
        $bookSagaReviewRate->load([ 'bookSagaReview']);

        return response()->json(['bookSagaReview' => new SagaReviewRateResource($bookSagaReviewRate)], 201);
    }

    

}
