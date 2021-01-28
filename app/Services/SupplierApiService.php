<?php

namespace App\Services;

use App\Models\Supplier;

class SupplierApiService
{
    public static function manageSupplier($request, $supplier = null)
    {
        $supplier_id = $supplier && $supplier->id ? $supplier->id : null;
        
        Supplier::updateOrcreate(
            [
                'id' => $supplier_id,
            ],
            [
                'name' => $request->name,
                'company_name' => $request->company_name,
                'address' => $request->address,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'bank_account' => $request->bank_account,
                'supplied_product' => $request->supplied_product,
                'remark' => $request->remark,
            ]);
    }
}
