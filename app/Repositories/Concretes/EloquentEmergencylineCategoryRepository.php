<?php

namespace App\Repositories\Concretes;

use App\EmergencylineCategory;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Resources\EmergencylineCategoryCollection;
use App\Http\Resources\EmergencylineCollection;
use App\Repositories\Contracts\EmergencylineCategoryInterface;

class EloquentEmergencylineCategoryRepository implements EmergencylineCategoryInterface
{
    /**
     * fetches all emergencyagencies resource.
     *
     * @return \App\Http\Resources\EmergencylineCollection
     */
    public function all()
    {
        $emergencylinescategories = QueryBuilder::for(EmergencylineCategory::class)->allowedSorts([
            'name'
        ])->get();

        return new EmergencylineCategoryCollection($emergencylinescategories);
    }

    /**
     * fetches all emergencylines for the given emergencyline category.
     *
     * @return \App\Http\Resources\EmergencylineCollection
     */
    public function getEmergencylines($id)
    {
        $emergencylinescategory = EmergencylineCategory::find($id);
        return new EmergencylineCollection($emergencylinescategory->emergencylines);
    }

    public function count(): int
    {
        return EmergencylineCategory::count();
    }

    public function find($id)
    {
        return EmergencylineCategory::find($id);
    }
}
