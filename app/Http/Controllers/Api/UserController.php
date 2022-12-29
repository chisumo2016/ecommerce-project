<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;

use App\Http\Resources\UserResource;


use App\Models\Api\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;



class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $search         = request('search', false);
        $perPage        = request('per_page', 10);
        $sortField      = request('sort_field', 'updated_at');
        $sortDirection  = request('sort_direction', 'desc');


        /**Search is available */
        $query = User::query()
            ->orderBy($sortField, $sortDirection)
            ->paginate($perPage);

        return UserResource::collection($query);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return UserResource
     */
    public function store(CreateUserRequest $request)
    {
        $data = $request->validated();
        $data['is_admin'] = true;
        $data['email_verified_at'] = date('Y-m-d H:i:s');
        $data['password']  = Hash::make($data['password']);

        $data['created_by'] = $request->user()->id;
        $data['updated_by'] = $request->user()->id;



        $User = User::create($data);

        return  new UserResource($User);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\user  $user
     * @return UserResource
     */
    public function update(UpdateUserRequest $request, User $user)
    {

        $data = $request->validated();

        if (!empty($data['password'])){
            $data['password']  = Hash::make($data['password']);
        }
       $data['updated_by'] = $request->user()->id;


        $user->update($data);

        return  new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return  response()->noContent();
    }

}
