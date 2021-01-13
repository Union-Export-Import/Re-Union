<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = ['permission_name'];

    // public function role()
    // {
    //     return $this->belongsTo(Role::class);
    // }

    public function scopeWherePermissionName($query, $name)
    {
        if ($name) {
            return $query->where('permission_name', $name);
        }
        return $query;
    }
}
