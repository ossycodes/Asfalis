<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Requests\UpdatePassword;

class UpdatePasswordController extends \App\Http\Controllers\Controller
{
    public function __construct()
    {
        return $this->middleware('jwt');
    }

    public function update(UpdatePassword $request)
    {
        auth()->user()->update([
            'password' => 'secret'
        ]);

        return response()->json([], \Symfony\Component\HttpFoundation\Response::HTTP_NO_CONTENT);
    }
}
