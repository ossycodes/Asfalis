<?php

namespace App;

use App\Events\UserCreated;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $with = ['emergencycontacts'];
    
    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => UserCreated::class,
    ];

    /**
     * Hashes/bcrypts the user's password.
     *
     * @param  string  $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function emergencycontacts()
    {
        return $this->hasMany(Emergencycontacts::class);
    }

    public function resettoken()
    {
        return $this->hasOne(ResetToken::class);
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function createResetToken()
    {
        $token = str_random();
        $this->resettoken()->create([
            'email' => $this->email,
            'token' => $token,
        ]);
        return $token;
    }

    public function hasResetToken()
    {
        return $this->resetToken()->exists();
    }

    public function register()
    {
        $defaultPassword = \Illuminate\Support\Str::random(10);

        $user = $this->create([
            'first_name' => request('first_name'),
            'last_name' => request('last_name'),
            'email' => request('email'),
            'phonenumber' => request('phonenumber'),
            'default_password' => $defaultPassword,
            'password' => $defaultPassword
        ]);

        return $user;
    }
}
