<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface TipsRepositoryInterface
{
    public function create(Request $request);

    public function find($id);

    public function update(Request $request, $id);

    public function all();
}
