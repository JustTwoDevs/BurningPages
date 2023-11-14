<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\SagaReviewRate;
use Illuminate\Http\Request;

class SagaReviewRateController extends Controller
{
    public function index()
    {
        $sagaReviewRates = SagaReviewRate::orderBy('id', 'asc')->get();

        return response()->json(['sagaReviewRates' => $sagaReviewRates], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $SagaReviewRate = SagaReviewRate::create($request->all());
        return response()->json(['SagaReviewRate' => $SagaReviewRate], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(SagaReviewRate $SagaReviewRate)
    {
        return response()->json(['SagaReviewRate' => $SagaReviewRate], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SagaReviewRate $SagaReviewRate)
    {
    
        $SagaReviewRate->update($request->all());

        return response()->json(['SagaReviewRate' => $SagaReviewRate], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SagaReviewRate $SagaReviewRate)
    {
        $SagaReviewRate->delete();
        return response(null, 204);
    }
}
