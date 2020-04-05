<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResetToken extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the user that has the reset token.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
