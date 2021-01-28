<?php

namespace App\GraphQL\Queries;

use App\Models\User;
use App\Traits\ResponserTrait;

class UserQuery
{

    public function filterUser($root, array $args)
    {
        $first = $args["first"];
        $page = $args["page"];

        $users = User::whereUserName($args["name"])
            ->whereUserEmail($args['email']);

        return $this->showTransactionPageData($users, $first, $page);
    }

    // public function filterPermission()
    // {
    //     return User::
    // }

    private function showTransactionPageData($users, $first, $page)
    {
        $users = $users->paginate($first, ['*'], 'page', $page);
        return [
            "data" => $users,
            "page" => [
                "currentPage" => $page,
                "lastPage" => $users->lastPage(),
            ],
        ];
    }
}
