<?php

namespace App\Repositories\Concretes;

use App\Tips;
use Illuminate\Http\Request;
use App\Repositories\Contracts\TipsRepositoryInterface;


class EloquentTipsRepository implements TipsRepositoryInterface
{
    /**
     * creates a tips resource.
     *
     * @param \illuminate\Http\Request $request
     * @return \App\Tips
     */
    public function create(Request $request)
    {
        $body = $request->validated()["data"]["attributes"]["body"];
        return Tips::create([
            "user_id" => auth()->id(),
            "body" => $body
        ]);
    }

    /**
     * find a tip by the given ID.
     *
     * @param integer $id
     * @return \App\Tips
     */
    public function find(int $id): Tips
    {
        return Tips::find($id);
    }

    /**
     * fetch all tips created.
     *
     * @param integer $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        Tips::where('id', $id)
            ->update($request->input('data.attributes'));
        return $this->find($id);
    }

    /**
     * fetch all tips created.
     *
     * @param integer $id
     * @return void
     */
    public function all()
    {
        return Tips::all();
    }
}
