<?php

namespace App\Http\Controllers\Api;

use App\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\NewsResource;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Resources\NewsCollection;

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
}
