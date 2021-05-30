<?php

namespace App\Services;

use App\Models\Customer;

class CustomerApiService
{
    public static function manageCustomer($request, $customer = null)
    {
        $customer_id = $customer && $customer->id ? $customer->id : null;
        Customer::updateOrcreate(
            [
                'id' => $customer_id,
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
