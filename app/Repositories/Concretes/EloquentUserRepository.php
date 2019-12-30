<?php

namespace App\Repositories\Concretes;

use App\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function getAuthenticatedUser()
    {
        // return auth()->user();
        return new \App\Http\Resources\User(auth()->user());
    }

    public function updateProfile()
    {
        return auth()->user()->update(request()->all());
    }
}
