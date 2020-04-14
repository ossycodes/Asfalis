<?php

namespace App\Repositories\Concretes;

use App\News;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use App\Repositories\Contracts\NewsRepositoryInterface;


class EloquentNewsRepository implements NewsRepositoryInterface
{
    public function find($id)
    {
        return News::find($id);
    }

    public function paginate(array $allowedSorts, ?int $perPage = null)
    {
        return  QueryBuilder::for(News::class)->allowedSorts($allowedSorts)->paginate($perPage);
    }

    public function create(Request $request)
    {
        return  News::create($request->input('data.attributes'));
    }

    public function update(Request $request, $id)
    {
        return News::where('id', $id)
            ->update($request->input('data.attributes'));
    }

    public function delete($id)
    {
        $news = News::find($id);
        return $news->delete();
    }
}
