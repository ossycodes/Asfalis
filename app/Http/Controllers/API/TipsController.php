<?php

namespace App\Http\Controllers\API;

use App\Tips;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTips;
use App\Http\Controllers\Controller;
use App\Http\Resources\TipsResource;
use App\Http\Resources\TipsCollection;
use App\Repositories\Contracts\TipsRepositoryInterface;

class TipsController extends Controller
{
    public $tipsRepo;

    public function __construct(TipsRepositoryInterface $tipsRepo)
    {
        $this->middleware('jwt', ["only" => "store"]);
        $this->tipsRepo = $tipsRepo;
    }

    public function index()
    {
        return new TipsCollection($this->tipsRepo->all());
    }

    public function show($id)
    {
        $tips = $this->tipsRepo->find($id);
        return new TipsResource($tips);
    }

    public function store(StoreTips $request)
    {
        $tips = $this->tipsRepo->create($request);
        return new TipsResource($tips);
    }
}
