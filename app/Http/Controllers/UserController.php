<?php

namespace App\Http\Controllers;

use App\Http\Requests\Role\AssignRoleRequest;
use App\Http\Requests\Role\RemoveRoleRequest;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\Role\RoleAdminService;
use App\Services\User\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $service;
    protected $roleService ;
    public function __construct(UserService $service , RoleAdminService $roleService)
    {
        $this->service = $service ;
        $this->roleService = $roleService ;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny' , User::class);
        $users = User::paginate(10);
        return self::paginated($users , UserResource::class);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $request)
    {
        $info = $this->service->create($request->validated());
        return $info['status'] === 'success'
            ? self::success([new UserResource($info['data'])] , 201)
            : self::error('Error Occurred' , $info['status'] , $info['code'] , [$info['error']]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $this->authorize('view' , $user);
        return self::success([new UserResource($user)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $info = $this->service->update($request->validated() , $user);
        return $info['status'] == 'success'
            ? self::success([new UserResource($info['data'])])
            : self::error('Error Occurred' , $info['status'] , $info['code'] , [$info['error']]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete' , $user);
        $user->delete();
        return self::success([null]);
    }
    public function assignRoleToUser(AssignRoleRequest $request){
        $info = $this->roleService->assignRoleToUser($request->validated());
        return $info['status'] == 'success'
            ? self::success([$info['data']])
            : self::error('Error Occurred' , $info['status'],400  ,[$info['error_message']]);
    }
    public function removeRoleFromUser(RemoveRoleRequest $request){
        $info = $this->roleService->removeRoleFromUser($request->validated());
        return $info['status'] == 'success'
            ? self::success([$info['data']])
            : self::error('Error Occurred' , $info['status'],400  ,[$info['error_message']]);
    }
}
