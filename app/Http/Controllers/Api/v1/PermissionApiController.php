<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionRequest;
use App\Models\Permission;
use App\Services\FilterQueryService;
use App\Traits\ResponserTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class PermissionApiController extends Controller
{
    use ResponserTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('permission_access'), $this->respondPermissionDenied());

        $permissions = Permission::paginate(10);

        return $this->respondCollectionWithPagination('success', $permissions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionRequest $request)
    {
        abort_if(Gate::denies('permission_create'), $this->respondPermissionDenied());

        Permission::create([
            'permission_name' => $request->permission_name,
        ]);
        return $this->respondCreateMessageOnly('success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        abort_if(Gate::denies('permission_update'), $this->respondPermissionDenied());

        $permission->update([
            'permission_name' => $request->permission_name,
        ]);
        return $this->respondCreateMessageOnly('success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        abort_if(Gate::denies('permission_delete'), $this->respondPermissionDenied());

        $permission->delete();

        return $this->respondSuccessMsgOnly('success');
    }

    public function query(Request $request)
    {
        abort_if(Gate::denies('permission_query'), $this->respondPermissionDenied());

        $permissions = DB::table('permissions');

        $data = FilterQueryService::FilterQuery($request, $permissions);

        return $this->respondCollectionWithPagination('success', $data);
    }

}
