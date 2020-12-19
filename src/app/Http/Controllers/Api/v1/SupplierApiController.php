<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Services\SupplierApiService;
use App\Services\UserApiService;
use App\Traits\ResponserTrait;
use Illuminate\Http\Request;

class SupplierApiController extends Controller
{
    use ResponserTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::latest()->paginate(10);

        return $this->respondCollectionWithPagination('success', $suppliers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = SupplierApiService::manageSupplier($request);

        UserApiService::UacLogCreate(json_encode($request->all()), 'supplier_create');

        return $this->respondCreateMessageOnly('success');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        $user = SupplierApiService::manageSupplier($request, $supplier);

        UserApiService::UacLogCreate(json_encode($request->all()), 'supplier_update');

        return $this->respondCreateMessageOnly('success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return $this->respondSuccessMsgOnly('success');
    }
}
