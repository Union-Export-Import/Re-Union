<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category_id', 'model_no', 'serial_no', 'asset_id', 'description'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function colors()
    {
        return $this->hasMany(ProductColor::class);
    }

    public function sizes()
    {
        return $this->hasMany(ProductSize::class);
    }

    public function suppliers()
    {
        return $this->hasMany(ProductPrice::class);
    }

    public function productPrices()
    {
        return $this->hasMany(ProductPrice::class);
    }

    public function scopeWhereProductName($query, $name)
    {
        if ($name) {
            return $query->where('name', $name);
        }
        return $query;
    }

    public function scopeWhereModelNo($query, $code)
    {
        if ($code) {
            return $query->where('model_no', $code);
        }
        return $query;
    }

    public function scopeWhereProductColor($query, $color)
    {
        if ($color) {
            return $query->whereHas('colors', function ($q) use ($color) {
                $q->where('color_id', $color);
            });
        }
        return $query;
    }

    public function scopeWhereProductSize($query, $size)
    {
        if ($size) {
            return $query->whereHas('sizes', function ($q) use ($size) {
                $q->where('size_id', $size);
            });
        }
        return $query;
    }

    public function scopeWhereProductSupplier($query, $supplier)
    {
        if ($supplier) {
            return $query->whereHas('suppliers', function ($q) use ($supplier) {
                $q->where('supplier_id', $supplier);
            });
        }
        return $query;
    }
}
