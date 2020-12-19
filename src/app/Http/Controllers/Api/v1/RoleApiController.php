<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use App\Traits\ResponserTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        DB::beginTransaction();
        $role = Role::create([
            'role_name' => $request->name
        ]);

        $new_permissions = $role->permissions()->createMany(
            $request->permissions
        );

        foreach ($new_permissions as $permission) {
            RolePermission::create(['role_id' => $role->id, 'permission_id' => $permission->id]);
        }

        if ($role->exists) {
            DB::commit();
            return $this->respondCreateMessageOnly('success');
        } else {
            DB::rollBack();
            return $this->respondCreateMessageOnly('please try again');
        }
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
        $role->update([
            'role_name' => $request->name
        ]);

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
}