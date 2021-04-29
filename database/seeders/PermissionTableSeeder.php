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
            ['permission_name' => 'user_access'],
            ['permission_name' => 'user_create'],
            ['permission_name' => 'user_update'],
            ['permission_name' => 'user_delete'],
            ['permission_name' => 'user_query'],
            ['permission_name' => 'forget_password'],
            ['permission_name' => 'old_password_change'],
            ['permission_name' => 'permission_access'],
            ['permission_name' => 'permission_create'],
            ['permission_name' => 'permission_update'],
            ['permission_name' => 'permission_delete'],
            ['permission_name' => 'permission_query'],
            ['permission_name' => 'role_access'],
            ['permission_name' => 'role_create'],
            ['permission_name' => 'role_show'],
            ['permission_name' => 'role_update'],
            ['permission_name' => 'role_delete'],
            ['permission_name' => 'role_query'],
            ['permission_name' => 'customer_access'],
            ['permission_name' => 'customer_create'],
            ['permission_name' => 'customer_update'],
            ['permission_name' => 'customer_delete'],
            ['permission_name' => 'category_access'],
            ['permission_name' => 'category_create'],
            ['permission_name' => 'category_update'],
            ['permission_name' => 'category_delete'],
            ['permission_name' => 'customer_query'],
            ['permission_name' => 'supplier_access'],
            ['permission_name' => 'supplier_create'],
            ['permission_name' => 'supplier_update'],
            ['permission_name' => 'supplier_delete'],
            ['permission_name' => 'supplier_query'],
            ['permission_name' => 'asset_type_access'],
            ['permission_name' => 'asset_type_create'],
            ['permission_name' => 'asset_type_update'],
            ['permission_name' => 'asset_type_delete'],
            ['permission_name' => 'asset_type_query'],
            ['permission_name' => 'asset_access'],
            ['permission_name' => 'asset_create'],
            ['permission_name' => 'asset_update'],
            ['permission_name' => 'asset_delete'],
            ['permission_name' => 'asset_query'],
            ['permission_name' => 'product_access'],
            ['permission_name' => 'product_create'],
            ['permission_name' => 'product_show'],
            ['permission_name' => 'product_update'],
            ['permission_name' => 'product_delete'],
            ['permission_name' => 'product_query'],
            ['permission_name' => 'sale_create'],
            ['permission_name' => 'sale_complete_payment'],
        ];
        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
