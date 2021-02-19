<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductPrice;
use App\Models\ProductSize;

class ProductApiService
{
    public static function createProduct($request)
    {
        return Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'product_code' => $request->product_code,
            'serial_no' => $request->serial_no,
            'asset_id' => $request->asset_id,
        ]);
    }

    public static function createProductColor($product, $price)
    {
        return ProductColor::create([
            'product_id' => $product->id,
            'color_id' => $price['value'],
        ]);
    }

    public static function createProductSize($product, $price)
    {
        return ProductSize::create([
            'product_id' => $product->id,
            'size_id' => $price['value'],
        ]);
    }

    public static function createProductPrice($price, $product_color, $product_size, $product_id)
    {
        ProductPrice::create([
            'quantity' => $price['quantity'],
            'buying_price' => $price['buying_price'],
            'selling_price' => $price['selling_price'],
            'supplier_id' => $price['supplier'],
            'product_color_id' => $product_color->id ?? null,
            'product_size_id' => $product_size->id ?? null,
            'product_id' => $product_id,
        ]);
    }

    public static function updateProduct($request, $product)
    {
        return $product->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'product_code' => $request->product_code,
            'serial_no' => $request->serial_no,
            'asset_id' => $request->asset_id,
        ]);
    }

    public static function updateProductColor($price)
    {
        $update_color = ProductColor::firstWhere('id', $price['product_color_id']);

        return $update_color->update([
            'color_id' => $price['value'],
        ]);
    }

    public static function updateProductSize($price)
    {
        $update_size = ProductSize::firstWhere('id', $price['product_size_id']);

        return $update_size->update([
            'size_id' => $price['value'],
        ]);
    }

    public static function updateProductPrice($price, $product_color, $product_size)
    {
        $product_price = ProductPrice::firstWhere('id', $price['id']);

        $product_price->update([
            'quantity' => $price['quantity'],
            'buying_price' => $price['buying_price'],
            'selling_price' => $price['selling_price'],
            'supplier_id' => $price['supplier'],
            'product_color_id' => $price['product_color_id'] ?? null,
            'product_size_id' => $product_size->id ?? null,
        ]);
    }

    public static function filterProduct($request)
    {
       $products = Product::whereProductName($request->name)
                ->whereProductCode($request->product_code)
                ->whereProductColor($request->color_id)
                ->whereProductColor($request->size_id)
                ->whereProductSupplier($request->supplier_id)->paginate(10);
        return $products;
    }
}
