<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmergencylineCategory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $with = ['emergencylines'];

    /**
     * Get the emergenylines related to the category.
     */
    public function emergencylines()
    {
        return $this->hasMany(Emergencyline::class, 'emergencylinecategory_id');
    }
}
