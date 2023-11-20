<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\v1\UserStoreRequest;
use App\Http\Requests\api\v1\UserUpdateRequest;
use Illuminate\Http\Request;
use App\Http\Requests\api\v1\UpdateMyPasswordRequest;
use App\Models\RegisteredUser;
use App\Models\User;

class RegisteredUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = request()->query();
        $users = RegisteredUser::query()->with('user.nationality')->get();

        /**
         * Filtrar por nombre.
         */
        if (isset($query['name'])) {
            $search = str_replace('-', ' ', $query['name']);
            $users = $users->where('concat(name, " ", lastname) like ?', '%' . $search . '%');
        }
        /**
         * Filtrar por nacionalidad.
         */
        if (isset($query['nationality'])) {
            $users = $users->where('user.nationality', $query['nationality']);
        }

        /**
         * Filtrar por fecha de nacimiento.
         */
        if (isset($query['birthdate'])) {
            $users = $users->where('birthdate', $query['birthdate']);
        }

        /**
         * Filtrar por username.
         */
        if (isset($query['username'])) {
            $users = $users->where('username', $query['username']);
        }

        /**
         * Filtrar por email.
         */
        if (isset($query['email'])) {
            $users = $users->where('email', $query['email']);
        }

        /**
         * Filtrat por rank.
         */
        if (isset($query['rank'])) {
            $users = $users->where('rank', $query['rank']);
        }

        /**
         * Filtrar por verified.
         */
        if (isset($query['verified'])) {
            $users = $users->where('verified', $query['verified']);
        }

        /**
         * Ordenar.
         */
        if (isset($query['sortBy'])) {
            $users = $users->orderBy($query['sortBy'], $query['order'] ?? 'asc');
        }

        /**
         * ordenar por likes.
         */

        return response()->json(['users' => $users]);
    }

    public function getProfiles()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        $user = User::create($request->all());
        $registeredUser = RegisteredUser::create(['user_id' => $user->id]);
        return response()->json(['user' => $registeredUser]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $userId)
    {
        $registeredUser = RegisteredUser::query()->whereKey($userId)->with('user.nationality')->first();
        if ($registeredUser == null) {
            return response()->json(['error' => 'User not found'], 404);
        }
        return response()->json(['registeredUser' => $registeredUser]);
    }

    public function getMyProfile()
    {
        $user = auth()->user();
        if ($user == null) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $registeredUser = RegisteredUser::query()->where('user_id', $user['id'])->with('user.nationality')->first();
        return response()->json(['myProfile' => $registeredUser]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, string $userId)
    {
        $registeredUser = RegisteredUser::query()->whereKey($userId)->with('user.nationality')->first();
        if ($registeredUser == null) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $registeredUser->update($request->all());
        $registeredUser->user->update($request->all());
        return response()->json(['registeredUser' => $registeredUser]);
    }

    public function updateMyProfile(UserUpdateRequest $request)
    {
        $user = auth()->user();
        if ($user == null) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $registeredUser = RegisteredUser::query()->where('user_id', $user['id'])->with('user.nationality')->first();
        $registeredUser->user->update($request->all());
        return response()->json(['myProfile' => $registeredUser]);
    }

    public function updateMyPassword(UpdateMyPasswordRequest $request)
    {
        $user = auth()->user();
        if ($user == null) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $registeredUser = RegisteredUser::query()->where('user_id', $user['id'])->with('user.nationality')->first();
        if ($registeredUser->user->password != $request->oldPassword) {
            return response()->json(['error' => 'Old password is incorrect'], 400);
        }
        $registeredUser->update(['password' => $request->newPassword]);
        return response()->json(['myProfile' => $registeredUser], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $userId)
    {
        if ($request->password == null) {
            return response()->json(['error' => 'Password is required'], 404);
        }
        $registeredUser = RegisteredUser::query()->find($userId);
        if ($registeredUser == null) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $registeredUser = User::query()->whereKey($registeredUser->id)->where('password', $request->password)->first();
        if ($registeredUser == null) {
            return response()->json(['error' => 'Password is incorrect'], 400);
        }
        $registeredUser->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }

    public function deleteMyProfile(Request $request)
    {
        if ($request->password == null) {
            return response()->json(['error' => 'Password is required'], 404);
        }
        $user = auth()->user();
        $registeredUser = RegisteredUser::query()->where('user_id', $user['id'])->with('user.nationality')->first();
        if ($registeredUser->password != $request->password) {
            return response()->json(['error' => 'Password is incorrect'], 400);
        }
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }
}
