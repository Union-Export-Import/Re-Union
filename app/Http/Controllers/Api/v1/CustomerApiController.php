<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerApiRequest;
use App\Models\Customer;
use App\Services\CustomerApiService;
use App\Services\FilterQueryService;
use App\Traits\ResponserTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class CustomerApiController extends Controller
{
    use ResponserTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('customer_access'), $this->respondPermissionDenied());

        $customers = Customer::latest()->paginate(10);

        return $this->respondCollectionWithPagination('success', $customers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerApiRequest $request)
    {
        abort_if(Gate::denies('customer_create'), $this->respondPermissionDenied());

        CustomerApiService::manageCustomer($request);

        return $this->respondCreateMessageOnly('success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        abort_if(Gate::denies('customer_update'), $this->respondPermissionDenied());

        CustomerApiService::manageCustomer($request);

        return $this->respondCreateMessageOnly('success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        abort_if(Gate::denies('customer_delete'), $this->respondPermissionDenied());

        $customer->delete();

        return $this->respondCreateMessageOnly('succes');
    }

    public function query(Request $request)
    {
        abort_if(Gate::denies('customer_query'), $this->respondPermissionDenied());

        $customers = DB::table('customers');

        $data = FilterQueryService::FilterQuery($request, $customers);

        return $this->respondCollectionWithPagination('success', $data);
    }
}
