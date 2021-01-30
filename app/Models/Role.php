<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['title'];


    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function scopeWhereRole($query,$role)
    {
        if ($role) {
            return $query->where('title',$role);
        }
        return $query;
    }
}
