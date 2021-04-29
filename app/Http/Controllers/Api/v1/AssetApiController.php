<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Services\FilterQueryService;
use App\Traits\ResponserTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

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
        abort_if(Gate::denies('asset_access'), $this->respondPermissionDenied());

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
        abort_if(Gate::denies('asset_create'), $this->respondPermissionDenied());

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
        $asset = Asset::findOrFail($id);

        return $this->respondCollection('success', $asset);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Asset $asset)
    {
        abort_if(Gate::denies('asset_update'), $this->respondPermissionDenied());

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
        abort_if(Gate::denies('asset_delete'), $this->respondPermissionDenied());

        $asset->delete();

        return $this->respondSuccessMsgOnly('success');
    }

    public function query(Request $request)
    {
        abort_if(Gate::denies('asset_query'), $this->respondPermissionDenied());

        $assets = DB::table('assets');

        $data = FilterQueryService::FilterQuery($request, $assets);

        return $this->respondCollectionWithPagination('success', $data);
    }
}
