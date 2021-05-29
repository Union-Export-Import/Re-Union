<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;
    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
    ];

    protected $fillable = ['asset_name','asset_type_id'];

    public function products(){
        return $this->hasMany(Product::class);
    }
     
    /**
     * Get the asset_types that owns the Asset
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function asset_type()
    {
        return $this->belongsTo(AssetType::class, 'asset_type_id');
    }
}
