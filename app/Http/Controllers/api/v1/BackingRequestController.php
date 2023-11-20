<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\BackingRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\api\v1\BackingRequestStoreRequest;
use App\Http\Requests\api\v1\BackingRequestUpdateRequest;
use App\Http\Resources\api\BackingRequestResource;

class BackingRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $backingRequests = BackingRequest::with('user')->orderBy('id', 'asc')->get();
        return response()->json(['backingRequests' => BackingRequestResource::collection($backingRequests)], 200);
    }

    public function indexByUser(string $user){
        $user=User::find($user);
        if(!$user){
            return response()->json(['message'=>'user not found'],404);
        }

        $user->load('backingRequests');
        return response()->json(['backingRequests'=>$user->backingRequests],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BackingRequestStoreRequest $request)
    {
        $backingRequest = BackingRequest::create($request->except('state'));
       
        $backingRequest->load('user');
        return response()->json(['backingRequest' => new BackingRequestResource($backingRequest)], 201);
    }

    public function approve(Request $request, BackingRequest $backingRequest)
    {
        $backingRequest->state = 'approved';
        $backingRequest->save();
        return response()->json(['backingRequest' => new BackingRequestResource($backingRequest)], 200);
    }

    public function reject(Request $request, BackingRequest $backingRequest)
    {
        $backingRequest->state = 'rejected';
        $backingRequest->save();
        return response()->json(['backingRequest' => new BackingRequestResource($backingRequest)], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(BackingRequest $backingRequest)
    {
        $backingRequest->load(['user']);
        return response()->json(['backingRequest' => new BackingRequestResource($backingRequest)], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BackingRequestUpdateRequest $request, BackingRequest $backingRequest)
    {
        $backingRequest->update($request->except(['state', 'user_id']));
        return response()->json(['backingRequest' => new BackingRequestResource($backingRequest)], 200);

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
