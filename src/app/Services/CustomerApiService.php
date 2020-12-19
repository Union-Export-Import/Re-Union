<?php

namespace App\Services;

use App\Models\Customer;

class CustomerApiService
{
    public static function manageCustomer($request)
    {
        Customer::updateOrcreate(
            [
                'phone_number' => $request->phone_number,
            ],
            [
                'name' => $request->name,
                'company_name' => $request->company_name,
                'address' => $request->address,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'bank_acc' => $request->bank_acc,
                'remark' => $request->remark,
            ]);
    }
}
