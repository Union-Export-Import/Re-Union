<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Models\RolePermission;
use App\Traits\ResponserTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\FilterQueryService;
use App\Http\Requests\PermissionRequest;

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
        $permission->delete();

        return $this->respondSuccessMsgOnly('success');
    }

    public function query(Request $request)
    {
        $permissions = DB::table('permissions');

        $data = FilterQueryService::FilterQuery($request, $permissions);

        return $this->respondCollectionWithPagination('success', $data);
    }

}
