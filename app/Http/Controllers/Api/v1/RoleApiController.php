<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Services\FilterQueryService;
use App\Services\RoleApiService;
use App\Traits\ResponserTrait;
use Highlight\Mode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class RoleApiController extends Controller
{
    use ResponserTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('role_access'), $this->respondPermissionDenied());

        $roles = Role::with('permissions')->paginate(10);

        return $this->respondCollectionWithPagination('success', $roles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('role_create'), $this->respondPermissionDenied());

        RoleApiService::manageRole($request);

        return $this->respondCreateMessageOnly('success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        abort_if(Gate::denies('role_show'), $this->respondPermissionDenied());

        $roleData = Role::with('permissions')->findOrFail($role->id);

        return $this->respondCollection('success', $roleData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        abort_if(Gate::denies('role_update'), $this->respondPermissionDenied());

        RoleApiService::manageRole($request, $role);

        return $this->respondCreateMessageOnly('success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        abort_if(Gate::denies('role_delete'), $this->respondPermissionDenied());

        $role->delete();

        return $this->respondCreateMessageOnly('success');
    }

    public function query(Request $request)
    {
        abort_if(Gate::denies('role_query'), $this->respondPermissionDenied());

        //Search roles with array
        $roles = DB::table('roles');

        $data = FilterQueryService::FilterQuery($request, $roles);

        return $this->respondCollectionWithPagination('success', $data);
    }

}
