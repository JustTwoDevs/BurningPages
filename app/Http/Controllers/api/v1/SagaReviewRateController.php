<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\SagaReviewRate;
use App\Models\BookSagaReview;
use Illuminate\Http\Request;
use App\Http\Requests\api\v1\SagaReviewRateStoreRequest;
use App\Http\Requests\api\v1\SagaReviewRateUpdateRequest;
use App\Http\Resources\api\SagaReviewRateResource;

class SagaReviewRateController extends Controller
{
    public function index()
    {
        $sagaReviewRates = SagaReviewRate::with('user', 'bookSagaReview')->orderBy('user_id', 'asc')->orderBy('bookSagaReview_id', 'asc')->get();

        return response()->json(['sagaReviewRates' => SagaReviewRateResource::collection($sagaReviewRates)], 200);
    }
    
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
    public function store(SagaReviewRateStoreRequest $request)
    {
        $SagaReviewRate = SagaReviewRate::create($request->all());
        return response()->json(['SagaReviewRate' => new SagaReviewRateResource($SagaReviewRate)], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(SagaReviewRate $sagaReviewRate)
    {
        $sagaReviewRate->load('user', 'bookSagaReview');
        return response()->json(['SagaReviewRate' => new SagaReviewRateResource($sagaReviewRate)], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SagaReviewRateUpdateRequest $request, SagaReviewRate $SagaReviewRate)
    {
    
        $SagaReviewRate->update($request->all());

        return response()->json(['SagaReviewRate' => new SagaReviewRateResource($SagaReviewRate)], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SagaReviewRate $SagaReviewRate)
    {
        $SagaReviewRate->delete();
        return response(null, 204);
    }
}
