<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\BookSagaReview;
use Illuminate\Http\Request;
use App\Models\BookSaga;

class BookSagaReviewController extends Controller
{
    public function index()
    {
        $bookSagaReviews = BookSagaReview::with('user', 'bookSaga')->orderBy('id', 'asc')->get();

        return response()->json(['bookSagaReviews' => $bookSagaReviews], 200);
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
    public function store(Request $request)
    {
        $bookSagaReview = BookSagaReview::create($request->all());
        return response()->json(['bookSagaReview' => $bookSagaReview], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(BookSagaReview $bookSagaReview)
    {
        return response()->json(['bookSagaReview' => $bookSagaReview], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BookSagaReview $bookSagaReview)
    {
    
        $bookSagaReview->update($request->except('state'));

        return response()->json(['bookSagaReview' => $bookSagaReview], 200);
    }

    public function publish(Request $request, BookSagaReview $review)
    {
        $review->update(['state' => 'published']);

        return response()->json(['review' => $review]);
    }

    public function occult(Request $request, BookSagaReview $review)
    {
        $review->update(['state' => 'hidden']);

        return response()->json(['review' => $review]);
    }

    public function addReviewRate(Request $request, string $bookSagaReview, string $sagaReviewRate)
    {
        $bookSagaReview = BookSagaReview::find($bookSagaReview);
        $bookSagaReview->reviewSagaRates()->attach($sagaReviewRate);
        return response()->json(['bookSagaReview' => $bookSagaReview], 201);
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
