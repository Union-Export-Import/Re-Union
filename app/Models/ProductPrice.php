<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    use HasFactory;

    protected $fillable = ['buying_date', 'buying_price', 'selling_price', 'quantity', 'product_color_id', 'product_size_id', 'supplier_id', 'product_id'];

    public function productColor()
    {
        return $this->belongsTo(ProductColor::class);
    }

    public function productSize()
    {
        return $this->belongsTo(ProductSize::class);
    }
}
