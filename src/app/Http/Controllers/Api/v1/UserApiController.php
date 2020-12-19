<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Services\UserApiService;
use App\Traits\EmailTrait;
use App\Traits\ResponserTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserApiController extends Controller
{
    use ResponserTrait;
    use EmailTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('roles', 'permissions')->paginate(10);

        return $this->respondCollectionWithPagination('success', $users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $auto_pwd = Str::random(8);
        // $auto_pwd = 'password';
        $hashed_random_password = Hash::make($auto_pwd);

        $user = UserApiService::manageUser($request, $hashed_random_password);

        $this->sendUserCreationEmail($user, $auto_pwd);

        UserApiService::UacLogCreate(json_encode($request->all()), 'user_create');

        return $this->respondCreateMessageOnly('success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user = UserApiService::manageUser($request, $user);

        UserApiService::UacLogCreate(json_encode($request->all()), 'user_update');

        return $this->respondCreateMessageOnly('success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return $this->respondCreateMessageOnly('succes');
    }

    public function query(Request $request)
    {
        $query = null;

        $filterExp = $request['filter']['filterParams'];

        if (count($filterExp) != 0) {
            foreach ($filterExp as $filterParam) {
                if ($filterParam['filterType'] == 'text') {
                    if ($filterParam['filterExpression'] == 'equals') {
                        $filterQuery = User::where($filterParam['key'], '=', $filterParam['textValue']['value']);
                        $query = clone $filterQuery;
                    }
                    if ($filterParam['filterExpression'] == 'notEquals') {
                        $filterQuery = User::where($filterParam['key'], '<>', $filterParam['textValue']['value']);
                        $query = clone $filterQuery;
                    }
                    if ($filterParam['filterExpression'] == 'contain') {
                        $filterQuery = User::where($filterParam['key'], 'LIKE', '%' . $filterParam['textValue']['value'] . '%');
                        $query = clone $filterQuery;
                    }
                }

                if ($filterParam['filterType'] == 'textArray') {
                    if ($filterParam['filterExpression'] == 'equals') {
                        $filterQuery = User::whereIn($filterParam['key'], $filterParam['textArrayValues']['list']);
                        $query = clone $filterQuery;
                    }
                    if ($filterParam['filterExpression'] == 'notEquals') {
                        $filterQuery = User::whereNotIn($filterParam['key'], $filterParam['textArrayValues']['list']);
                        $query = clone $filterQuery;
                    }
                }
            }
        }

        // if (count($request['roles']) != 0 || $request['roles'] != null) {
        //     $users = $query->with('roles', 'permissions')->get();
        //     foreach ($users as $user) :
        //         foreach ($user->roles as $r) :

        //             if($r['role_name'] == $request[roles])

        //         endforeach;
        //     endforeach;
        // }

        if ($request != null) {
            $query = $query->orderBy(
                $request['sortingParams']['key'],
                $request['sortingParams']['sortType']
            )->with('roles', 'permissions')->paginate(
                $request['paginationParam']['pageSize'],
                ['*'],
                'page',
                $request['paginationParam']['pageNumber']
            );
        }


        return $this->respondCollectionWithPagination('success', $query);
    }

    public function oldPasswordChange(Request $request)
    {
        $user = User::firstWhere('email', $request->email);
        if ($user) {
            $user->update([
                'password' => Hash::make($request->new_password),
                'is_password_changed' => true
            ]);
        }
        return $this->respondCreateMessageOnly('success');
    }
}