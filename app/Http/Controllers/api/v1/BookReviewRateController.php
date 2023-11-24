<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\BookReviewRate;
use Illuminate\Http\Request;
use App\Models\RegisteredUser;
use App\Models\ReviewRate;
use App\Http\Resources\api\BookReviewResource;

class BookReviewRateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $bookReviewId)
    {
        $user = auth()->user();
        $registeredUser = RegisteredUser::query()->where('user_id', $user['id'])->first();
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
      
        $bookReviewRate->load([ 'bookReview', 'reviewRate']);

        return response()->json(['reviewRate' => new BookReviewResource($bookReviewRate)], 201);
    }

}
