<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\BookSagaReview;
use Illuminate\Http\Request;

class BookSagaReviewController extends Controller
{
    public function index()
    {
        $bookSagaReviews = BookSagaReview::orderBy('id', 'asc')->get();

        return response()->json(['bookSagaReviews' => $bookSagaReviews], 200);
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
    
        $bookSagaReview->update($request->all());

        return response()->json(['bookSagaReview' => $bookSagaReview], 200);
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
