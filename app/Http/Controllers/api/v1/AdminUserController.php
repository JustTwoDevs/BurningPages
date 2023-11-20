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
        $users = AdminUser::query()->with('user.nationality')->get();

        /**
         * Filtrar por nombre.
         */
        if (isset($query['name'])) {
            $search = str_replace('-', ' ', $query['name']);
            $users = $users->where('concat(user.name, " ", lastname) like ?', '%' . $search . '%');
        }
        /**
         * Filtrar por nacionalidad.
         */
        if (isset($query['nationality'])) {
            $users = $users->where('nationality', $query['nationality']);
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
         * Ordenar.
         */
        if (isset($query['sortBy'])) {
            $users = $users->orderBy($query['sortBy'], $query['order'] ?? 'asc');
        }

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
        $adminUser = AdminUser::query()->find($userId);
        if (!$adminUser) {
            return response()->json(['message' => 'Admin user not found'], 404);
        }
        $adminUser->delete();
        return response()->json(['adminUser' => $adminUser]);
    }
}
