<?php

namespace App\Http\Controllers\API\Admin;

use App\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\NewsResource;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Resources\NewsCollection;
use App\Http\Requests\CreateNewsRequest;
use App\Http\Requests\UpdateNewsRequest;

class NewsController extends Controller
{
    public function index()
    {
        $news = QueryBuilder::for(News::class)->allowedSorts([
            'title',
            'description'
        ])->paginate();

        return new NewsCollection($news);
    }

    public function show($id)
    {
        $news = News::find($id);
        return new NewsResource($news);
    }

    public function update(UpdateNewsRequest $request,  $id)
    {
        //in your rules, create a custom rule, that ensures the id
        //given in the url, macthes the id given in the body
        News::where('id', $id)
            ->update($request->input('data.attributes'));
        $news = News::find($id);
        return new NewsResource($news);
    }

    public function store(CreateNewsRequest $request)
    {
        $news = News::create($request->input('data.attributes'));
        return (new NewsResource($news))
            ->response()
            ->header('Location', route('news.show', ['id' =>
            $news->id]));
    }

    public function destroy($id)
    {
        $news = News::find($id);
        $news->delete();
        return response(null, 204);
    }
}
