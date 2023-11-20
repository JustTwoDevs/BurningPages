<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\BookReview;
use App\Models\Book;
use App\Models\User;
use App\Models\ReviewRate;
use Illuminate\Http\Request;
use App\Http\Requests\api\v1\ReviewStoreRequest;
use App\Http\Requests\api\v1\ReviewUpdateRequest;
use App\Http\Resources\api\ReviewResource;

class BookReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookReviews = BookReview::with('book', 'user', 'reviewRates')->orderBy('id', 'asc')->get();

        return response()->json(['bookReviews' => ReviewResource::collection($bookReviews)], 200);
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
    public function store(ReviewStoreRequest $request)
    {
        $bookReview = BookReview::create($request->except('state'));
        $bookReview->load(['reviewRates', 'book', 'user']);
        
        return response()->json(['bookReview' => new ReviewResource($bookReview)], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(BookReview $bookReview)
    {
        $bookReview->load(['reviewRates', 'book', 'user']);
        return response()->json(['bookReview' => new ReviewResource($bookReview)], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReviewUpdateRequest $request, BookReview $bookReview)
    {
    
        $bookReview->update($request->except(['state','book_id','user_id']));

        return response()->json(['bookReview' =>new  ReviewResource($bookReview)], 200);
    }

    public function publish(Request $request, BookReview $review)
    {
        $review->state='published';
        $review->save();
        return response()->json(['review' =>new ReviewResource($review)]);
    }

    public function occult(Request $request, BookReview $review)
    {
        $review->state='hidden';
        $review->save();
        return response()->json(['review' => new ReviewResource($review)]);
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
