<?php

namespace App\Http\Controllers\Api;

use App\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\NewsResource;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Resources\NewsCollection;
use App\Repositories\Contracts\NewsRepositoryInterface;

class NewsController extends Controller
{
    public $newsRepo;

    public function __construct(NewsRepositoryInterface $newsRepo)
    {
        $this->newsRepo = $newsRepo;
    }

    public function index()
    {
        if ($this->newsRepo->count() == 0) {
            return $this->errorNotFound("No news available at the moment");
        }

        return $this->newsRepo->all();
    }

    public function show($id)
    {
        return $this->newsRepo->find($id);
    }
}
