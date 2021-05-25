<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductPrice;

class ProductApiService
{
    public static function createProduct($request)
    {
        return Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'model_no' => $request->model_no,
            'serial_no' => $request->serial_no,
            'asset_id' => $request->asset_id,
            'description' => $request->description
        ]);
    }

    public static function createProductPrice($price, $product_id)
    {
        ProductPrice::create([
            'quantity' => $price['quantity'],
            'buying_date' => $price['buying_date'],
            'buying_price' => $price['buying_price'],
            'selling_price' => $price['selling_price'],
            'supplier_id' => $price['supplier_id'],
            'product_id' => $product_id,
            'specification' => $price['specification']
        ]);
    }

    public static function updateProduct($request, $product)
    {
        return $product->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'model_no' => $request->model_no,
            'serial_no' => $request->serial_no,
            'asset_id' => $request->asset_id,
            'description' => $request->description
        ]);
    }

    public static function updateProductPrice($price)
    {
        $product_price = ProductPrice::firstWhere('id', $price['id']);


        $product_price->update([
            'quantity' => $price['quantity'],
            'buying_price' => $price['buying_price'],
            'selling_price' => $price['selling_price'],
            'supplier_id' => $price['supplier_id'],
            'specification' => $price['specification']
        ]);
    }

    public static function filterProduct($request)
    {
        $products = Product::whereProductName($request->name)
            ->WhereModelNo($request->model_no)
            ->whereProductSupplier($request->supplier_id)->paginate(10);
        return $products;
    }
}
