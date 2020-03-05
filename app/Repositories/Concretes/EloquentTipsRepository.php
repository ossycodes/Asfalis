<?php

namespace App\Repositories\Concretes;

use App\Tips;
use Illuminate\Http\Request;
use App\Repositories\Contracts\TipsRepositoryInterface;


class EloquentTipsRepository implements TipsRepositoryInterface
{
    public function create(Request $request)
    {
        $body = $request->validated()["data"]["attributes"]["body"];
        return Tips::create([
            "user_id" => auth()->id(),
            "body" => $body
        ]);
    }

    public function find(int $id): Tips
    {
        return Tips::find($id);
    }

    public function all()
    {
        return Tips::all();
    }
}
