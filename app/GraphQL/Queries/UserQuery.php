<?php


namespace App\GraphQL\Queries;

use App\Models\User;

class UserQuery
{
    public function filterUser($root, array $args)
    {

        return User::query()
            ->where('name', $args['name'])
            ->get();
    }
}
