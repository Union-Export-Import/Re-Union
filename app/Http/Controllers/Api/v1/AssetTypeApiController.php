<?php

namespace App\Http\Controllers\Api\v1;
use App\Models\AssetType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AssetTypeRequest;
use App\Traits\ResponserTrait;

class AssetTypeApiController extends Controller
{
    use ResponserTrait;

    public function index()
    {
        $asset_types = AssetType::paginate(10);

        return $this->respondCollectionWithPagination('success', $asset_types);
    }

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

    public function update(Request $request, AssetType $assetType)
    {
        $assetType->update([
            'asset_type' => $request->asset_type,
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
