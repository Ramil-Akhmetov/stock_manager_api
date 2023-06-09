<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api']);

        $this->middleware(['can:users.create'],['only' => ['store']]);
        $this->middleware(['can:users.read'],['only' => ['index', 'show']]);
        $this->middleware(['can:users.update'],['only' => ['update']]);
        $this->middleware(['can:users.delete'],['only' => ['destroy']]);
    }
    public function index()
    {
        $users = User::paginate();
        return new UserCollection($users);
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->validated());
        $user->assignRole($request->input('roles'));
        return new UserResource($user);
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());
        $user->syncRoles($request->input('roles'));

        return new UserResource($user);
    }

    public function destroy(User $user)
    {
        $user->delete();
    }
}
