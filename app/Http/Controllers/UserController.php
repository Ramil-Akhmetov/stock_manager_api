<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\IndexUserRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api']);

        $this->middleware(['can:users.create'], ['only' => ['store']]);
        $this->middleware(['can:users.read'], ['only' => ['index', 'show']]);
        $this->middleware(['can:users.update'], ['only' => ['update']]);
        $this->middleware(['can:users.delete'], ['only' => ['destroy']]);
    }
    public function index(IndexUserRequest $request)
    {
        $validated = $request->validated();

        $limit = isset($validated['limit']) ? $validated['limit'] : 10;
        $filters = isset($validated['search']) ? $validated['search'] : null;
        $orderBy = isset($validated['order_by']) ? $validated['order_by'] : 'created_at';
        $order = isset($validated['order']) ? $validated['order'] : 'desc';

        $query = User::query();
        if ($filters) {
            $query->where('surname', 'like', '%' . $filters . '%')
                ->orWhere('name', 'like', '%' . $filters . '%')
                ->orWhere('patronymic', 'like', '%' . $filters . '%')
                ->orWhere('email', 'like', '%' . $filters . '%')
                ->orWhere('phone', 'like', '%' . $filters . '%');
        }

        $users = $query->orderBy($orderBy, $order)->paginate($limit);

        return new UserCollection($users);
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->validated());
        $user->assignRole($request->input('roles'));
        $invite_code = InviteCodeController::generateCode();
        $user->invite_code()->create(['code' => $invite_code]);

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
