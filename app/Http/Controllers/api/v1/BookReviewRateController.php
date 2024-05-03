<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\BookReviewRate;
use Illuminate\Http\Request;
use App\Models\RegisteredUser;
use App\Models\ReviewRate;
use App\Http\Resources\api\BookReviewResource;
use App\Models\BookReview;

class BookReviewRateController extends Controller
{

    
    /**
     * Display a listing of the resource.
     */
    public function indexByReview(string $bookReviewId)
    {
        $bookReviewRates = BookReviewRate::with('bookReview', 'reviewRate')->orderBy('id', 'asc')->get();
        $bookReviewRates = $bookReviewRates->filter(function ($review) use ($bookReviewId) {
            return  $review->bookReview_id == $bookReviewId;
        });
        return response()->json(['bookReviewRates' => BookReviewResource::collection($bookReviewRates)], 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $bookReviewId)
    {
        $bookReview = BookReview::find($bookReviewId);
        if (!$bookReview) {
            return response()->json(['message' => 'book review not found'], 404);
        }

        $user = auth()->user();
        $registeredUser = RegisteredUser::query()->where('user_id', $user['id'])->first();
        // si ya existe una reviewrate de este usuario para esta review, no se le permite crear otro
        $bookReviewRate = BookReviewRate::with('bookReview', 'reviewRate')->orderBy('id', 'asc')->get();
        $bookReviewRate = $bookReviewRate->filter(function ($review) use ($bookReviewId, $registeredUser) {
            return  $review->bookReview_id == $bookReviewId && $review->reviewRate->user_id == $registeredUser->id;
        });
        if ($bookReviewRate->count() > 0) {
            return response()->json(['message' => 'user already has a review rate for this review'], 400);
        }
        $data = [
            'value' => $request->input('value'),
            'user_id' => $registeredUser->id,
        ];
        $reviewRate = ReviewRate::create($data);

        $data = [
            'bookReview_id' => $bookReviewId,
            'reviewRate_id' => $reviewRate->id,
        ];

        $bookReviewRate = BookReviewRate::create($data);

        $bookReviewRate->load('bookReview.review.user', 'reviewRate');

        $user = $bookReviewRate->bookReview->review->user;

        if ($bookReviewRate->reviewRate->value != null) {

            $user->likeDifference = $user->likeDifference = $bookReviewRate->reviewRate->value == 1 ? $user->likeDifference + 1 : $user->likeDifference - 1;
            $user->save();
        }

        $bookReviewRate->load(['bookReview', 'reviewRate', 'reviewRate.user']);

        return response()->json(['reviewRate' => new BookReviewResource($bookReviewRate)], 201);
    }
}
