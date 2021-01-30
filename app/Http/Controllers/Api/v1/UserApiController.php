<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserApiDetailResourse;
use App\Models\UacLog;
use App\Models\User;
use App\Services\FilterQueryService;
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
        $users = User::with('roles')->paginate(10);

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
        // dd($request->all());
        $auto_pwd = Str::random(8);
        $hashed_random_password = Hash::make($auto_pwd);

        $exist_user = User::firstWhere('email', $request->email);

        if (!$exist_user) {
            $user = UserApiService::createUser($request, $hashed_random_password);

            // if ($user == config('enums.users')['DUP']) {
            //     return $this->duplicateEntry();
            // }
            UserApiService::UacLogCreate(json_encode($request->all()), 'user_create', $user->id);

            $this->sendUserCreationEmail($user, $auto_pwd);

            return $this->respondCreateMessageOnly($user);
        } else {
            return $this->duplicateEntry();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $this->respondCollection('success', new UserApiDetailResourse($user));
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
        $exist_user = User::firstWhere('email', $request->email);

        $user = UserApiService::updateUser($request, $user);

        UserApiService::UacLogCreate(json_encode($request->all()), 'user_update', $user->id);

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
        try {
            $user = User::findOrFail($user->id);
        } catch (\Exception $exception) {
            $errormsg = 'No User to delete' . $exception->getCode();
            return $this->errorResponse($errormsg);
        }

        $result = $user->delete();
        if ($result) {
            $user_response['result'] = true;
            $user_response['message'] = "User Successfully Deleted!";
        } else {
            $user_response['result'] = false;
            $user_response['message'] = "User was not Deleted, Try Again!";
        }

        return $this->respondCreateMessageOnly($user_response['message']);
    }

    public function oldPasswordChange(Request $request)
    {
        $user = User::firstWhere('email', $request->email);
        if ($user) {
            $user->update([
                'password' => Hash::make($request->new_password),
                'account_status' => config('enums.account_status')['ACTIVE'],
            ]);
            return $this->respondCreateMessageOnly('success');
        } else {
            return $this->respondErrorToken('Enter Correct Eamil');
        }
    }

    public function forgetPassword(Request $request)
    {
        $user = User::firstWhere('email', $request->email);

        if ($user) {
            $auto_pwd = Str::random(8);

            $hashed_random_password = Hash::make($auto_pwd);
            $user->update([
                'password' => $hashed_random_password,
            ]);

            $this->sendUserCreationEmail($user, $auto_pwd);

            return $this->respondCreateMessageOnly('success');
        } else {
            return $this->respondErrorToken('Enter Correct Email');
        }
    }

    // public function filterUser($name)
    // {
    //     // return $name;
    //     return User::filterUser($name)->get();
    // }
    public function myProfile()
    {
        return request()->user();
    }

    public function query(Request $request)
    {
        //Search roles with array
        $role = $request["filterRole"];
        // dd($role);
        $users = User::with('roles')->whereRole($role);
        // return $users->get();
        $data = FilterQueryService::FilterQuery($request, $users);

        return $this->respondCollectionWithPagination('success', $data);
    }
}
