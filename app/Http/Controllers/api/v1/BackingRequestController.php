<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\BackingRequest;
use Illuminate\Http\Request;

class BackingRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $backingRequests = BackingRequest::with('user')->orderBy('id', 'asc')->get();
        return response()->json(['backingRequests' => $backingRequests], 200);
    }

    public function indexByUser(string $user){
        $user=User::find($user);
        if(!$user){
            return response()->json(['message'=>'user not found'],404);
        }

        $user->load('backingRequests');
        return response()->json(['backingRequests'=>$user],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $backingRequest = BackingRequest::create($request->all());

        return response()->json(['backingRequest' => $backingRequest], 201);
    }

    public function approve(Request $request, BackingRequest $backingRequest)
    {
        $backingRequest->update(['state' => 'approved']);
        return response()->json(['backingRequest' => $backingRequest], 200);
    }
    public function reject(Request $request, BackingRequest $backingRequest)
    {
        $backingRequest->update(['state' => 'rejected']);
        return response()->json(['backingRequest' => $backingRequest], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(BackingRequest $backingRequest)
    {
        $backingRequest->load(['user_id']);
        return response()->json(['backingRequest' => $backingRequest], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BackingRequest $backingRequest)
    {
        $backingRequest->update($request->all());

        return response()->json(['backingRequest' => $backingRequest], 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BackingRequest $backingRequest)
    {
        $backingRequest->delete();
        return response(null, 204);
    }
}
