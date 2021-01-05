<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            ['permission_name' => 'create_user', 'role_id' => '1'],
            ['permission_name' => 'update_user', 'role_id' => '1'],
            ['permission_name' => 'delete_user', 'role_id' => '1'],
            ['permission_name' => 'view_user', 'role_id' => '1']
        ];
        foreach($permissions as $permission){
            Permission::create($permission);
        }
        
    }
}
