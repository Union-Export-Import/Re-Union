<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['invoice_no', 'seller_name', 'product_list', 'size', 'quantity', 'subtotal_price', 'total_price', 'remark'];

}
