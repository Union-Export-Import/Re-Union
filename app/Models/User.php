<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'nrc',
        'phone_number',
        'account_status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

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

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function scopeWhereUserName($query, $name)
    {
        if ($name) {
            return $query->where('name', 'LIKE', "%{$name}%");
        }
        return $query;
    }

    public function scopeWhereUserEmail($query, $email)
    {
        if ($email) {
            return $query->where('email', 'LIKE', "%{$email}%");
        }
    }

    public function filterUser($query, $name, $email)
    {

        if ($name != null) {
            $query->where('name', 'LIKE', '%' . $name . '%');
        }
        if ($email != null) {
            $query->where('email', 'LIKE', '%' . $email . '%');
        }
        return $query;
    }

    public function scopeWhereRole($query, $role)
    {
        if ($role) {
            return $query->whereHas('roles', function ($q) use ($role) {
                $q->whereIn('role_id', $role);
            });
        }
        return $query;
    }

    public function logs()
    {
        return $this->hasMany(UacLog::class);
    }
}
