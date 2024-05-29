<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\BackingRequest;
use App\Models\RegisteredUser;
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

    public function indexByUser(Request $request, string $user)
    {
        $user = RegisteredUser::find($user);
        if (!$user) {
            return response()->json(['message' => 'user not found'], 404);
        }

        $user->load('backingRequests');
        return response()->json(['backingRequests' => $user->backingRequests], 200);
    }

    public function indexByProfile()
    {
        $user = auth()->user();
        $registeredUser = RegisteredUser::query()->where('user_id', $user['id'])->first();
        $backingRequests = BackingRequest::with('user')->orderBy('id', 'asc')->get();
        $backingRequests = $backingRequests->filter(function ($backingRequest) use ($registeredUser) {
            return $backingRequest->user->id == $registeredUser->id;
        });
        return response()->json(['backingRequests' => BackingRequestResource::collection($backingRequests)], 200);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(BackingRequestStoreRequest $request)
    {
        $user = auth()->user();
        $registeredUser = RegisteredUser::query()->where('user_id', $user['id'])->first();

        $backingRequests = BackingRequest::with('user')->orderBy('id', 'asc')->get();
        $backingRequests = $backingRequests->filter(function ($backingRequest) use ($registeredUser) {
            return $backingRequest->user->id == $registeredUser->id;
        });
        $backingRequests = $backingRequests->filter(function ($backingRequest) {
            return $backingRequest->state === 'approved' || $backingRequest->state === 'pending';
        });
        if ($backingRequests->count() > 0) {
            return response()->json(['message' => 'User already has an approved or pending backing request'], 400);
        }
        $data = [
            'user_id' => $registeredUser->id,
            'content' => $request->input('content'),
        ];
        $backingRequest = BackingRequest::create($data);

        //  $backingRequest->load( 'user' );
        $backingRequest->state = 'pending';
        $backingRequest->save();
        return response()->json(['backingRequest' => new BackingRequestResource($backingRequest)], 201);
    }

    public function approve(Request $request, BackingRequest $backingRequest)
    {
        if ($backingRequest->state === 'pending') {
            $backingRequest->state = 'approved';
            $backingRequest->save();
            $user = $backingRequest->user;
            if ($user) {
                if ($user->verified == 0) {
                    $user->verified = true;
                    $user->save();
                    $backingRequest->save();
                }
            }
            return response()->json(['backingRequest' => new BackingRequestResource($backingRequest)], 200);
        }
        return response()->json(['message' => 'backing request not pending'], 400);
    }

    public function reject(Request $request, BackingRequest $backingRequest)
    {
        if ($backingRequest->state === 'pending') {
            $backingRequest->state = 'rejected';
            $backingRequest->save();
            return response()->json(['backingRequest' => new BackingRequestResource($backingRequest)], 200);
        }
        return response()->json(['message' => 'backing request not pending'], 400);
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
