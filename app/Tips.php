<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tips extends Model
{
    /**
     * Get the user that created the tip.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ["user"];
}
