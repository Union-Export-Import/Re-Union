<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Sale;
use App\Models\SaleDetail;

class SaleApiService
{
    public static function saleCreate($request, $total_price)
    {
        return Sale::create([
            'customer_id' => $request['customer_id'],
            'sale_date' => Carbon::now(),
            'sale_status' => "pending",
            'total_products' => count($request->saleProductList),
            'total_price' => $total_price,
        ]);
    }

    public static function saleDetailCreate($sale, $saleProduct, $product_price)
    {
        SaleDetail::create([
            'sale_id' => $sale->id,
            'product_id' => $saleProduct['product_id'],
            'quantity' => $saleProduct['quantity'],
            'unit_cost' => $product_price->selling_price,
            'total' => $product_price->selling_price * $saleProduct['quantity'],
        ]);
    }
}
