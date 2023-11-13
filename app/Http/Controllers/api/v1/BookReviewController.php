<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\BookReview;
use Illuminate\Http\Request;

class BookReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookReviews = BookReview::orderBy('id', 'asc')->get();

        return response()->json(['bookReviews' => $bookReviews], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $bookReview = BookReview::create($request->all());
        return response()->json(['backingRequest' => $bookReview], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(BookReview $bookReview)
    {
        return response()->json(['bookReview' => $bookReview], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BookReview $bookReview)
    {
    
        $bookReview->update($request->all());

        return response()->json(['bookReview' => $bookReview], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BookReview $bookReview)
    {
        $bookReview->delete();
        return response(null, 204);
    }
}
