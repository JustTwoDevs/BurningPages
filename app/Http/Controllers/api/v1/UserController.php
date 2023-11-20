<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\v1\UserUpdateRequest;
use App\Models\User;
use App\Models\AdminUser;
use App\Models\RegisteredUser;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = request()->query();
        $users = User::query()->with('nationality');

        /**
         * Filtrar por nombre.
         */
        if (isset($query['name'])) {
            $search = str_replace('-', ' ', $query['name']);
            $users = $users->where('name', 'like', '%' . $search . '%');
        }

        /**
         * Filtrar por apellido.
         */
        if (isset($query['lastname'])) {
            $search = str_replace('-', ' ', $query['lastname']);
            $users = $users->where('lastname', 'like', '%' . $search . '%');
        }


        /**
         * Filtrar por nacionalidad.
         */
        if (isset($query['nationality'])) {
            $users = $users->whereHas('nationality', function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query['nationality'] . '%');
            });
        }

        /**
         * Filtrar por username.
         */
        if (isset($query['username'])) {
            $search = str_replace('-', ' ', $query['username']);
            $users = $users->where('username', 'like', '%' . $search . '%');
        }

        /**
         * Filtrar por email.
         */
        if (isset($query['email'])) {
            $search = str_replace('-', ' ', $query['email']);
            $users = $users->where('email', 'like', '%' . $search . '%');
        }
        /**
         * Ordenamientos.
         * orderBy - Agrega una clausula order by a la consulta
         *    orderBy('columna', 'asc|desc')
         */
        if (isset($query['sortBy'])) {

            if ($query['sortBy'] == 'name') {
                $users = $users->orderBy('name', $query['sortOrder'] ?? 'desc');
            }
        }


        $users = $users->get();
        return response()->json(['users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return response()->json(['message' => 'is not posible to create a user from api']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $userId)
    {
        $user = AdminUser::query()->where('user_id', $userId)->first();
        if (!$user) {
            $user = RegisteredUser::query()->where('user_id', $userId)->first();
            if (!$user) {
                return response()->json(['message' => 'user not found'], 404);
            }
        }
        $user->load('user.nationality');
        return response()->json(['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, string $id)
    {
        $user = User::query()->find($id);
        if (!$user) {
            return response()->json(['message' => 'user not found'], 404);
        }
        $user->update($request->all());
        return response()->json(['user' => $user]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return response()->json(['message' => 'is not posible to delete a user from api']);
    }
}
