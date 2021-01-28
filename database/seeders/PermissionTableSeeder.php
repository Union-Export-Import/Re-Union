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
            ['permission_name' => 'create_user'],
            ['permission_name' => 'update_user'],
            ['permission_name' => 'delete_user'],
            ['permission_name' => 'view_user']
        ];
        foreach($permissions as $permission){
            Permission::create($permission);
        }

    }
}
