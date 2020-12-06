<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssetTypeRequest;
use App\Models\AssetType;
use App\Traits\ResponserTrait;
use Illuminate\Http\Request;

class AssetTypeController extends Controller
{
    use ResponserTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $asset_types = AssetType::paginate(10);

        return $this->respondCollectionWithPagination('success', $asset_types);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AssetTypeRequest $request)
    {
        AssetType::create([
            'asset_type' => $request->asset_type,
        ]);

        return $this->respondCreateMessageOnly('success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AssetType  $assetType
     * @return \Illuminate\Http\Response
     */
    public function show(AssetType $assetType)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AssetType  $assetType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AssetType $assetType)
    {
        $assetType->update([
            'asset_type' => $request->asset_type,
        ]);
        
        return $this->respondCreateMessageOnly('success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AssetType  $assetType
     * @return \Illuminate\Http\Response
     */
    public function destroy(AssetType $assetType)
    {
        $assetType->delete();

        return $this->respondCreateMessageOnly('success');
    }
}
