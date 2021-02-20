<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductApiRequest;
use App\Http\Resources\ProductDetailResource;
use App\Http\Resources\ProductListResource;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductPrice;
use App\Models\ProductSize;
use App\Services\FilterQueryService;
use App\Services\ProductApiService;
use App\Traits\ResponserTrait;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    use ResponserTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate(10);

        return $this->respondCollectionWithPagination("success", ProductListResource::collection($products));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductApiRequest $request)
    {
        $product = ProductApiService::createProduct($request);

        foreach ($request->prices as $price) {
            if ($price['type'] == "color") {
                $product_color = ProductApiService::createProductColor($product, $price);
            }
            if ($price['type'] == "size") {
                $product_size = ProductApiService::createProductSize($product, $price);
            }
            ProductApiService::createProductPrice($price, $product_color ?? null, $product_size ?? null, $product->id);
        }

        return $this->respondSuccessMsgOnly("success");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return $this->respondcreateCollection('success', new ProductDetailResource($product));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $product_id = ProductApiService::updateProduct($request, $product);

        foreach ($request->prices as $price) {
            if ($price['type'] == "color") {
                $product_color = ProductApiService::updateProductColor($price);
            }
            if ($price['type'] == "size") {
                $product_size = ProductApiService::updateProductSize($price);
            }
            ProductApiService::updateProductPrice($price, $product_color ?? null, $product_size ?? null);
        }

        return $this->respondSuccessMsgOnly("success");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        ProductColor::where('product_id', $product->id)->delete();
        ProductSize::where('product_id', $product->id)->delete();
        ProductPrice::where('product_id', $product->id)->delete();
        $product->delete();

        return $this->respondSuccessMsgOnly("success");
    }

    public function productPriceDelete(Request $request)
    {
        $product_price = ProductPrice::firstWhere('id', $request->product_price_id);
        ProductColor::where('id', $product_price->product_color_id)->delete();
        ProductSize::where('id', $product_price->product_size_id)->delete();
        $product_price->delete();
        return $this->respondSuccessMsgOnly("success");
    }

    public function query(Request $request)
    {
        $data = ProductApiService::filterProduct($request);

        $products = Product::whereProductColor($request["color_id"])
                        ->whereProductSize($request["size_id"])
                        ->whereProductSupplier($request['supplier_id']);

        $data = FilterQueryService::FilterQuery($request, $products);

        return $this->respondCollectionWithPagination('success', ProductListResource::collection($data));
    }
}
