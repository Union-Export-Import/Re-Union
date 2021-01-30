<?php

namespace App\Http\Controllers\Api\v1;

use Highlight\Mode;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Traits\ResponserTrait;
use App\Services\RoleApiService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\FilterQueryService;
use Illuminate\Database\Eloquent\Model;

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
        $role->delete();

        return $this->respondCreateMessageOnly('success');
    }

    public function query(Request $request)
    {
        //Search roles with array
        $roles = DB::table('roles');

        $data = FilterQueryService::FilterQuery($request, $roles);

        return $this->respondCollectionWithPagination('success', $data);
    }

}
