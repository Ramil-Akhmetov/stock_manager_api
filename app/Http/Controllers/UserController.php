<?php

namespace App\Http\Controllers;

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
    public function index(Request $request)
    {
        $filters = $request->all('search');
        //TODO remove only_verified_at
        //TODO add order by like in ActivityController
        if ($request->input('only_verified') == 'true') {
            $users = User::where('email_verified_at', '!=', null)->filter($filters)->paginate();
        } else {
            $users = User::filter($filters)->paginate();
        }
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
