<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = ['asset_name', 'asset_type_id'];

    public function products(){
        return $this->hasMany(Product::class);
    }
}
