<?php

namespace App\Http\Controllers;

use App\Models\UacLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\FilterQueryService;
use App\Traits\ResponserTrait;

class UacLogController extends Controller
{
    use ResponserTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UacLog  $uacLog
     * @return \Illuminate\Http\Response
     */
    public function show(UacLog $uacLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UacLog  $uacLog
     * @return \Illuminate\Http\Response
     */
    public function edit(UacLog $uacLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UacLog  $uacLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UacLog $uacLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UacLog  $uacLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(UacLog $uacLog)
    {
        //
    }
    public function query(Request $request)
    {
        $uacLogs = DB::table('uac_logs');

        $data = FilterQueryService::FilterQuery($request, $uacLogs);

        return $this->respondCollectionWithPagination('success', $data);

    }
}
