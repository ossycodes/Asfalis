<?php

namespace App\Http\Controllers\Api\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Resources\UsersCollection;
use App\Http\Resources\User as UserResource;

class UsersController extends Controller
{
    public function index()
    {
        $users = QueryBuilder::for(User::class)->allowedSorts([
            'email',
            'phonenumber'
        ])->paginate();

        return new UsersCollection($users);
    }

    public function show($id)
    {
        $user = User::find($id);
        return new UserResource($user);
    }
}
