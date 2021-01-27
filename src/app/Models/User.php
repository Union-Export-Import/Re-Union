<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
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

}
