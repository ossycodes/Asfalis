<?php

namespace App\Http\Controllers\API\Admin;

use App\Tips;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTipsRequest;
use App\Http\Requests\UpdateTipsRequest;
use App\Http\Resources\TipsResource;
use App\Http\Resources\TipsCollection;
use App\Repositories\Contracts\TipsRepositoryInterface;

class TipsController extends Controller
{
    public $tipsRepo;

    public function __construct(TipsRepositoryInterface $tipsRepo)
    {
        $this->tipsRepo = $tipsRepo;
    }

    public function index()
    {
        // return new TipsCollection(Tips::all());
        return new TipsCollection($this->tipsRepo->all());
    }

    public function show($id)
    {
        // $tips = Tips::find($id);
        $tips = $this->tipsRepo->find($id);
        return new TipsResource($tips);
    }

    public function update(UpdateTipsRequest $request,  $id)
    {
        //in your rules, create a custom rule, that ensures the id
        //given in the url, macthes the id given in the body
        // Tips::where('id', $id)
        //     ->update($request->input('data.attributes'));
        // $tips = Tips::find($id);
        // return new TipsResource($tips);

        $tips = $this->tipsRepo->update($request, $id);
        return new TipsResource($tips);
    }

    public function store(CreateTipsRequest $request)
    {
        // $tip = Tips::create($request->input('data.attributes'));
        $tip = $this->tipsRepo->create($request);
        return (new TipsResource($tip))
            ->response()
            ->header('Location', route('tip.show', ['id' =>
            $tip->id]));
    }

    public function destroy($id)
    {
        $tips = $this->tipsRepo->find($id);
        $tips->delete();
        return response(null, 204);
    }
}
