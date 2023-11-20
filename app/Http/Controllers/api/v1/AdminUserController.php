<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\v1\UserStoreRequest;
use App\Http\Requests\api\v1\UserUpdateRequest;
use App\Models\AdminUser;
use App\Models\User;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = request()->query();
        $users = AdminUser::query()->with('user.nationality');

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
        return response()->json(['adminUsers' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        $user = User::create($request->all());
        $adminUser = AdminUser::create(['user_id' => $user->id]);
        return response()->json(['adminUser' => $adminUser]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $userId)
    {
        $adminUser = AdminUser::query()->find($userId);
        if (!$adminUser) {
            return response()->json(['message' => 'Admin user not found'], 404);
        }
        $adminUser->load('user');
        $adminUser->user->load('nationality');
        return response()->json(['adminUser' => $adminUser]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, string $userId)
    {
        $adminUser = AdminUser::query()->find($userId);
        if (!$adminUser) {
            return response()->json(['message' => 'Admin user not found'], 404);
        }
        $adminUser->load('user');
        $adminUser->user->update($request->all());
        return response()->json(['adminUser' => $adminUser]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $userId)
    {
        $adminUser = AdminUser::query()->whereKey($userId)->with('user')->first();
        if (!$adminUser) {
            return response()->json(['message' => 'Admin user not found'], 404);
        }
        $adminUser->user->delete();
        return response()->json(['message' => 'Admin user deleted successfully']);
    }
}
