<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Services\FilterQueryService;
use App\Services\SupplierApiService;
use App\Services\UserApiService;
use App\Traits\ResponserTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

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
        abort_if(Gate::denies('supplier_access'), $this->respondPermissionDenied());

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
        abort_if(Gate::denies('supplier_create'), $this->respondPermissionDenied());

        $user = SupplierApiService::manageSupplier($request);

        // UserApiService::UacLogCreate(json_encode($request->all()), 'supplier_create');

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
        abort_if(Gate::denies('supplier_access'), $this->respondPermissionDenied());

        
        return $this->respondCollection('success', Supplier::find($id));
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
        abort_if(Gate::denies('supplier_update'), $this->respondPermissionDenied());

        $user = SupplierApiService::manageSupplier($request, $supplier);

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
        abort_if(Gate::denies('supplier_delete'), $this->respondPermissionDenied());

        $supplier->delete();

        return $this->respondSuccessMsgOnly('success');
    }

    public function query(Request $request)
    {
        abort_if(Gate::denies('supplier_access'), $this->respondPermissionDenied());

        $suppliers = DB::table('suppliers');

        $data = FilterQueryService::FilterQuery($request, $suppliers);

        return $this->respondCollectionWithPagination('success', $data);
    }
}
