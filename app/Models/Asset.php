<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

<<<<<<< HEAD
    protected $fillable = ['asset_name', 'asset_type_id'];
=======
    protected $fillable = ['asset_name','asset_type_id'];

    public function products(){
        return $this->hasMany(Product::class);
    }
>>>>>>> a332b07a3724244b2b20f6eb14a244775563df5f
}
