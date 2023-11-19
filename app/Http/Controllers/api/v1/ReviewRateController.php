<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\ReviewRate;
use Illuminate\Http\Request;
use App\Models\BookReview;
use App\Http\Requests\api\v1\ReviewRatesStoreRequest;
use App\Http\Requests\api\v1\ReviewRatesUpdateRequest;
use App\Http\Resources\api\ReviewRateResource;

class ReviewRateController extends Controller
{
    public function index()
    {
     $reviewRates = ReviewRate::with('user', 'bookReview')->orderBy('user_id', 'asc')->orderBy('bookReview_id', 'asc')->get();

    return response()->json(['reviewRates' => ReviewRateResource::collection($reviewRates)], 200);
    }

    public function indexByReview(string $review){
        $review=BookReview::find($review);
        if(!$review){
            return response()->json(['message'=>'review not found'],404);
        }

        $review->load('reviewRates');
        return response()->json(['reviewRates'=>$review->reviewRates],200);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReviewRatesStoreRequest $request)
    {
        $ReviewRate = ReviewRate::create($request->all());
        $ReviewRate->load('user', 'bookReview');
        return response()->json(['ReviewRate' => new ReviewRateResource($ReviewRate)], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(ReviewRate $reviewRate)
    {
        $reviewRate->load('user', 'bookReview');
        return response()->json(['ReviewRate' => new ReviewRateResource($reviewRate)], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReviewRatesUpdateRequest $request, ReviewRate $reviewRate)
    {
    
        $reviewRate->update($request->all());
        $reviewRate->load('user', 'bookReview');

        return response()->json(['ReviewRate' => new ReviewRateResource($reviewRate)], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReviewRate $ReviewRate)
    {
        $ReviewRate->delete();
        return response(null, 204);
    }
}
