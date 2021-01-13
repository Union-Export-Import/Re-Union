<?php

namespace App\GraphQL\Queries;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;

class FilterQuery
{
    public function filterUser($root, array $args)
    {
        $first = $args["first"];
        $page = $args["page"];

        $users = User::whereUserName($args["name"])
            ->whereUserEmail($args['email']);

        return $this->showFilterPageData($users, $first, $page);
    }

    public function filterPermission($root, array $args)
    {
        $name = $args["name"];
        $first = $args["first"];
        $page = $args["page"];
        $permissions =  Permission::wherePermissionName($name);

        return $this->showFilterPageData($permissions, $first, $page);
    }

    public function filterRoles($root, array $args)
    {
        $name = $args["name"];
        $first = $args["first"];
        $page = $args["page"];

        $roles = Role::whereRole($name);

        return $this->showFilterPageData($roles, $first, $page);
    }

    private function showFilterPageData($users, $first, $page)
    {
        $users = $users->paginate($first, ['*'], 'page', $page);
        return [
            "data" => $users,
            "page" => [
                "currentPage" => $page,
                "lastPage" => $users->lastPage(),
                'hasNextPage' => $users->previousPageUrl(),
                'hasPreviousPage' => $users->previousPageUrl(),
                'total' => $users->total(),
            ],
        ];
    }
}
