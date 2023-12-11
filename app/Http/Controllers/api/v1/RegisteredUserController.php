<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\v1\UserStoreRequest;
use App\Http\Requests\api\v1\UserUpdateRequest;
use Illuminate\Http\Request;
use App\Http\Requests\api\v1\UpdateMyPasswordRequest;
use App\Http\Resources\api\ProfileResource;
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
        $users = RegisteredUser::query()->with('user.nationality');

        /**
         * Filtrar por nombre.
         */
        if (isset($query['name'])) {
            $search = str_replace('-', ' ', $query['name']);
            $users = $users->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        /**
         * Filtrar por apellido.
         */
        if (isset($query['lastname'])) {
            $search = str_replace('-', ' ', $query['lastname']);
            $users = $users->whereHas('user', function ($q) use ($search) {
                $q->where('lastname', 'like', '%' . $search . '%');
            });
        }


        /**
         * Filtrar por nacionalidad.
         */
        if (isset($query['nationality'])) {
            $users = $users->whereHas('user', function ($q) use ($query) {
                $q->whereHas('nationality', function ($q) use ($query) {
                    $q->where('name', 'like', '%' . $query['nationality'] . '%');
                });
            });
        }

        /**
         * Filtrar por username.
         */
        if (isset($query['username'])) {
            $search = str_replace('-', ' ', $query['username']);
            $users = $users->whereHas(
                'user',
                function ($q) use ($search) {
                    $q->where('username', 'like', '%' . $search . '%');
                }
            );
        }

        /**
         * Filtrar por email.
         */
        if (isset($query['email'])) {
            $search = str_replace('-', ' ', $query['email']);
            $users = $users->whereHas(
                'user',
                function ($q) use ($search) {
                    $q->where('email', 'like', '%' . $search . '%');
                }
            );
        }

        /**
         * Filtrar por rank.
         */
        if (isset($query['rank'])) {
            $users = $users->where('rank', $query['rank']);
        }

        /**
         * Filtrar por verificado.
         */
        if (isset($query['verified'])) {
            $users = $users->where('verified', $query['verified']);
        }

        /**
         * Ordenamientos.
         * orderBy - Agrega una clausula order by a la consulta
         *    orderBy('columna', 'asc|desc')
         */
        if (isset($query['sortBy'])) {

            if ($query['sortBy'] == 'name') {
                $users = $users->whereHas('user', function ($q) use ($query) {
                    $q->orderBy('name', $query['order'] ?? 'asc');
                });
            }
        }


        $users = $users->get();
        foreach ($users as $user) {
            $user->rank = $user->rank();
        }
        return response()->json(['users' => $users]);
    }

    public function getProfiles()
    {
        $query = request()->query();
        $users = RegisteredUser::query()->with('user.nationality');

        /**
         * Filtrar por nombre.
         */
        if (isset($query['name'])) {
            $search = str_replace('-', ' ', $query['name']);
            $users = $users->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        /**
         * Filtrar por apellido.
         */
        if (isset($query['lastname'])) {
            $search = str_replace('-', ' ', $query['lastname']);
            $users = $users->whereHas('user', function ($q) use ($search) {
                $q->where('lastname', 'like', '%' . $search . '%');
            });
        }


        /**
         * Filtrar por nacionalidad.
         */
        if (isset($query['nationality'])) {
            $users = $users->whereHas('user', function ($q) use ($query) {
                $q->whereHas('nationality', function ($q) use ($query) {
                    $q->where('name', 'like', '%' . $query['nationality'] . '%');
                });
            });
        }

        /**
         * Filtrar por username.
         */
        if (isset($query['username'])) {
            $search = str_replace('-', ' ', $query['username']);
            $users = $users->whereHas(
                'user',
                function ($q) use ($search) {
                    $q->where('username', 'like', '%' . $search . '%');
                }
            );
        }

        /**
         * Filtrar por email.
         */
        if (isset($query['email'])) {
            $search = str_replace('-', ' ', $query['email']);
            $users = $users->whereHas(
                'user',
                function ($q) use ($search) {
                    $q->where('email', 'like', '%' . $search . '%');
                }
            );
        }

        /**
         * Filtrar por rank.
         */
        if (isset($query['rank'])) {
            $users = $users->where('rank', $query['rank']);
        }

        /**
         * Filtrar por verificado.
         */
        if (isset($query['verified'])) {
            $users = $users->where('verified', $query['verified']);
        }

        /**
         * Ordenamientos.
         * orderBy - Agrega una clausula order by a la consulta
         *    orderBy('columna', 'asc|desc')
         */
        if (isset($query['sortBy'])) {

            if ($query['sortBy'] == 'name') {
                $users = $users->whereHas('user', function ($q) use ($query) {
                    $q->orderBy('name', $query['order'] ?? 'asc');
                });
            }
        }


        $users = $users->get();
        return response()->json(['profiles' => ProfileResource::collection($users)]);
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

    public function getProfile(string $userId)
    {
        $profile = RegisteredUser::query()->whereKey($userId)->with('user.nationality')->first();
        if ($profile == null) {
            return response()->json(['error' => 'User not found'], 404);
        }
        return response()->json(['profile' => new ProfileResource($profile)]);
    }

    public function getMyProfile()
    {
        $user = auth()->user();
        if ($user == null) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $registeredUser = RegisteredUser::query()->where('user_id', $user['id'])->with('user.nationality')->first();
        $registeredUser->rank = $registeredUser->rank();
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
        $user = User::query()->whereKey($user['id'])->where('password', $request->oldPassword)->first();
        if ($user == null) {
            return response()->json(['error' => 'The old password is incorrect'], 400);
        }
        $user->update(['password' => $request->newPassword]);
        return response()->json(['myProfile' => $user], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $userId)
    {
        $registeredUser = RegisteredUser::query()->whereKey($userId)->with('user')->first();
        if ($registeredUser == null) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $registeredUser->user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }

    public function deleteMyProfile()
    {
        $user = auth()->user();
        $user->delete();
        return response()->json(['message' => 'profile deleted successfully']);
    }
}
