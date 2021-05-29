<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssetTypeRequest;
use App\Models\AssetType;
use App\Services\FilterQueryService;
use App\Traits\ResponserTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class AssetTypeApiController extends Controller
{
    use ResponserTrait;

    public function index()
    {
        abort_if(Gate::denies('asset_type_access'), $this->respondPermissionDenied());

        $asset_types = AssetType::paginate(10);

        return $this->respondCollectionWithPagination('success', $asset_types);
    }

    public function store(AssetTypeRequest $request)
    {
        abort_if(Gate::denies('asset_type_create'), $this->respondPermissionDenied());

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
        // $asset = AssetType::findOrFail($assetType);

        return $this->respondCollection('success', $assetType);
    }

    public function update(Request $request, AssetType $assetType)
    {
        abort_if(Gate::denies('asset_type_update'), $this->respondPermissionDenied());

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
        abort_if(Gate::denies('asset_type_delete'), $this->respondPermissionDenied());

        $assetType->delete();

        return $this->respondCreateMessageOnly('success');
    }

    public function query(Request $request)
    {
        abort_if(Gate::denies('asset_type_query'), $this->respondPermissionDenied());

        $asset_types = DB::table('asset_types');

        $data = FilterQueryService::FilterQuery($request, $asset_types);

        return $this->respondCollectionWithPagination('success', $data);
    }
}
