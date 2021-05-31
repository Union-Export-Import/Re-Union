<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Product;
use App\Models\ProductSize;
use App\Models\ProductColor;
use App\Models\ProductPrice;
use Illuminate\Http\Request;
use App\Traits\ResponserTrait;
use App\Services\ProductApiService;
use App\Http\Controllers\Controller;
use App\Services\FilterQueryService;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\ProductApiRequest;
use App\Http\Resources\ProductListResource;
use App\Http\Resources\ProductDetailResource;

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
        abort_if(Gate::denies('product_access'), $this->respondPermissionDenied());

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
        abort_if(Gate::denies('product_create'), $this->respondPermissionDenied());

        $product = ProductApiService::createProduct($request);

        foreach ($request->prices as $price) {
            ProductApiService::createProductPrice($price, $product->id);
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
        abort_if(Gate::denies('product_show'), $this->respondPermissionDenied());

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
        abort_if(Gate::denies('product_update'), $this->respondPermissionDenied());

        $product_id = ProductApiService::updateProduct($request, $product);

        foreach ($request->prices as $price) {
            ProductApiService::updateProductPrice($price);
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
        abort_if(Gate::denies('product_delete'), $this->respondPermissionDenied());

        ProductPrice::where('product_id', $product->id)->delete();
        $product->delete();

        return $this->respondSuccessMsgOnly("success");
    }

    public function productPriceDelete(Request $request)
    {
        $product_price = ProductPrice::firstWhere('id', $request->product_price_id);
        $product_price->delete();
        return $this->respondSuccessMsgOnly("success");
    }

    public function query(Request $request)
    {
        abort_if(Gate::denies('product_query'), $this->respondPermissionDenied());

        $data = ProductApiService::filterProduct($request);

        $products = Product::with(['asset'])
                        ->whereProductSupplier($request['supplier_id']);

        $data = FilterQueryService::FilterQuery($request, $products);

        return $this->respondCollectionWithPagination('success', ProductListResource::collection($data));
    }
}
