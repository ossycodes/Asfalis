<?php

namespace App;

use App\Events\EmergencycontactCreated;
use Illuminate\Database\Eloquent\Model;

class Emergencycontacts extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => EmergencycontactCreated::class,
    ];

    /**
     * Get the user that registerd the In case of Emergency contact.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
