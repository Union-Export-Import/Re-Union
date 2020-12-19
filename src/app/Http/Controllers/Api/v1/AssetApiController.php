<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Traits\ResponserTrait;
use Illuminate\Http\Request;

class AssetApiController extends Controller
{
    use ResponserTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assets = Asset::paginate(10);

        return $this->respondCollectionWithPagination('success', $assets);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Asset::create([
            'asset_name' => $request->asset_name,
            'asset_type_id' => $request->asset_type_id,
        ]);

        return $this->respondSuccessMsgOnly('success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
    public function update(Request $request,Asset $asset)
    {
        $asset->update([
            'asset_name' => $request->asset_name,
            'asset_type_id' => $request->asset_type_id,
        ]);

        return $this->respondSuccessMsgOnly('success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Asset $asset)
    {
        $asset->delete();

        return $this->respondSuccessMsgOnly('success');
    }
}
