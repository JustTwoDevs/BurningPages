<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\BookReview;
use App\Models\Book;
use App\Models\User;
use App\Models\ReviewRate;
use Illuminate\Http\Request;

class BookReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookReviews = BookReview::with('book', 'user', 'reviewRates')->orderBy('id', 'asc')->get();

        return response()->json(['bookReviews' => $bookReviews], 200);
    }

    public function indexByUser(string $user){
        $user=User::find($user);
        if(!$user){
            return response()->json(['message'=>'user not found'],404);
        }

        $user->load('reviews');
        return response()->json(['reviews'=>$user->reviews],200);

    }

    public function indexByBook(Request $request,string $book){
    
        $book=Book::find($book);
        if(!$book){
            return response()->json(['message'=>'book not found'],404);
        }

        $book->load('reviews');
        return response()->json(['reviews'=>$book->reviews],200);

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
        $bookReview->load(['reviewRates', 'book', 'user']);
        return response()->json(['bookReview' => $bookReview], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BookReview $bookReview)
    {
    
        $bookReview->update($request->except('state'));

        return response()->json(['bookReview' => $bookReview], 200);
    }

    public function publish(Request $request, BookReview $review)
    {
        $review->update(['state' => 'published']);

        return response()->json(['review' => $review]);
    }

    public function occult(Request $request, BookReview $review)
    {
        $review->update(['state' => 'hidden']);

        return response()->json(['review' => $review]);
    }

    public function addReviewRate(Request $request, string $bookReview, string $reviewRate)
    {
        $bookReview = BookReview::find($bookReview);
        $bookReview->reviewRates()->attach($reviewRate);
        return response()->json(['bookReview' => $bookReview], 201);
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
