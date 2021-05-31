<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    use HasFactory;

    protected $fillable = ['buying_date', 'buying_price', 'selling_price', 'quantity', 'supplier_id', 'product_id', 'specification'];

    /**
     * Get the supplier that owns the ProductPrice
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

}
