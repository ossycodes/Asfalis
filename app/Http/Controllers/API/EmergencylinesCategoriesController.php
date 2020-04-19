<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\EmergencylineCategory;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Resources\EmergencylineCategoryCollection;
use App\Repositories\Contracts\EmergencylineCategoryInterface;

class EmergencylinesCategoriesController extends Controller
{
    public $emergencylinescategoryRepo;

    public function __construct(EmergencylineCategoryInterface $emergencylinescategoryRepo)
    {
        $this->emergencylinescategoryRepo = $emergencylinescategoryRepo;
    }

    public function index()
    {
        if ($this->emergencylinescategoryRepo->count() == 0) {
            return $this->errorNotFound("No emrgencylines available for the given category at the moment");
        }
        return $this->emergencylinescategoryRepo->all();
    }

    public function show($id)
    {
        if (!$this->emergencylinescategoryRepo->find($id)) {
            return $this->errorNotFound("Emergencyline category for the given ID does not exist");
        }
        return $this->emergencylinescategoryRepo->getEmergencylines($id);
    }
}
