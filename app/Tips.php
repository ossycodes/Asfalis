<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tips extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $guarded = [];

    protected $with = ["user"];
}
