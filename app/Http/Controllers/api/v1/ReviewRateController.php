<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\ReviewRate;
use Illuminate\Http\Request;

class ReviewRateController extends Controller
{
    public function index()
    {
        $reviewRates = ReviewRate::orderBy('id', 'asc')->get();

        return response()->json(['reviewRates' => $reviewRates], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $ReviewRate = ReviewRate::create($request->all());
        return response()->json(['ReviewRate' => $ReviewRate], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(ReviewRate $ReviewRate)
    {
        return response()->json(['ReviewRate' => $ReviewRate], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ReviewRate $ReviewRate)
    {
    
        $ReviewRate->update($request->all());

        return response()->json(['ReviewRate' => $ReviewRate], 200);
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
