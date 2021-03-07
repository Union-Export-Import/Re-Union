<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\ProductPrice;
use App\Models\Sale;
use App\Services\SaleApiService;
use App\Traits\ResponserTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SaleApiController extends Controller
{
    use ResponserTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('sale_create'), $this->respondPermissionDenied());

        $total_price = null;

        foreach ($request->saleProductList as $saleProduct) {
            $product_prices = ProductPrice::firstWhere('id', $saleProduct['product_price_id']);

            $total_price += $saleProduct['quantity'] * $product_prices->selling_price;
        }

        $sale = SaleApiService::saleCreate($request, $total_price);

        foreach ($request->saleProductList as $saleProduct) {
            $product_price = ProductPrice::firstWhere('id', $saleProduct['product_price_id']);

            SaleApiService::saleDetailCreate($sale, $saleProduct, $product_price);
        }

        return $this->respondCreateMessageOnly('success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        //
    }

    public function completePayment(Request $request)
    {
        abort_if(Gate::denies('sale_complete_payment'), $this->respondPermissionDenied());

        $sale = Sale::firstWhere('id', $request['sale_id']);

        $sale->update([
            'pay' => $request['pay'],
            'change' => $request['pay'] - $sale->total_price,
            'sale_status' => "completed",
        ]);

        return $this->respondCollection('success', $sale);
    }
}
