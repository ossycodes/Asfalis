<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface NewsRepositoryInterface
{
    public function create(Request $request);

    public function find($id);

    public function update(Request $request, $id);

    public function all();

    public function delete($id);

    public function paginate(array $allowedSorts, ?int $perPage);

    public function count(): int;
}
