<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\BookReview;
use App\Models\Book;
use App\Models\RegisteredUser;
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
    public function registeredIndex()
    {
        $bookReviews = BookReview::with('book', 'user', 'reviewRates')->orderBy('id', 'asc')->get();

        return response()->json(['bookReviews' => ReviewResource::collection($bookReviews)], 200);
    }

    public function index()
    {
        $bookReviews = BookReview::with('book', 'user', 'reviewRates')->orderBy('id', 'asc')->get();
        $publishedReviews = $bookReviews->filter(function ($review) {
            return $review->state === 'published';
        });
        return response()->json(['bookReviews' => ReviewResource::collection($publishedReviews)], 200);
    }

    public function indexMyBookReviews()
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['message' => 'user not found'], 404);
        }
        $registeredUser = RegisteredUser::query()->where('user_id', $user['id'])->first();
        $registeredUser->load('reviews.book', 'reviews.user');
        return response()->json(['reviews' => $registeredUser->reviews], 200);
    }

    public function indexByUser(Request $request, string $user)
    {
        $user = RegisteredUser::find($user);
        if (!$user) {
            return response()->json(['message' => 'user not found'], 404);
        }

        $user->load('reviews.book', 'reviews.user');

        $publishedReviews = $user->reviews->filter(function ($review) {
            return $review->state === 'published';
        });

        return response()->json(['reviews' => $publishedReviews], 200);
    }

    public function indexByUserAdmin(Request $request, string $user)
    {
        $user = RegisteredUser::find($user);
        if (!$user) {
            return response()->json(['message' => 'user not found'], 404);
        }

        $user->load('reviews.book', 'reviews.user');

        return response()->json(['reviews' => $user->reviews], 200);
    }


    public function indexByBook(Request $request, string $book)
    {

        $book = Book::find($book);
        if (!$book) {
            return response()->json(['message' => 'book not found'], 404);
        }

        $book->load('reviews');
        $publishedReviews = $book->reviews->filter(function ($review) {
            return $review->state === 'published';
        });
        return response()->json(['reviews' => $publishedReviews], 200);
    }

    public function indexByBookRegistered(Request $request, string $book)
    {
        $book = Book::find($book);
        if (!$book) {
            return response()->json(['message' => 'book not found'], 404);
        }

        $book->load('reviews');
        return response()->json(['reviews' => $book->reviews], 200);
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
        if ($bookReview->state === 'published') {
            return response()->json(['bookReview' => new ReviewResource($bookReview)], 200);
        }
        return response()->json(['review not found'], 404);
    }

    public function showRegistered(BookReview $bookReview)
    {
        $bookReview->load(['reviewRates', 'book', 'user']);
        return response()->json(['bookReview' => new ReviewResource($bookReview)], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReviewUpdateRequest $request, BookReview $bookReview)
    {

        $bookReview->update($request->except(['state', 'book_id', 'user_id']));
        $bookReview->load(['reviewRates', 'book', 'user']);

        return response()->json(['bookReview' => new  ReviewResource($bookReview)], 200);
    }

    public function publishAdmin(Request $request, BookReview $review)
    {
        if ($review->state === 'occult') {
            $review->state = 'published';
            $review->save();
            return response()->json(['review' => new ReviewResource($review)]);
        }
        return response()->json(['message' => 'review is not occult'], 400);
    }

    public function publishRegistered(Request $request, BookReview $review)
    {
        if ($review->state === 'draft') {
            $review->state = 'published';
            $review->save();
            return response()->json(['review' => new ReviewResource($review)]);
        }
        return response()->json(['message' => 'review is not a draft'], 400);
    }

    public function occult(Request $request, BookReview $review)
    {
        if ($review->state === 'published') {
            $review->state = 'hidden';
            $review->save();
            return response()->json(['review' => new ReviewResource($review)]);
        }
        return response()->json(['message' => 'review is not published'], 400);
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
