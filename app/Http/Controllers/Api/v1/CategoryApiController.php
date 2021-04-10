<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Traits\ResponserTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\CategoryApiService;
use App\Services\FilterQueryService;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\CategoryRequest;

class CategoryApiController extends Controller
{

    use ResponserTrait;

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        abort_if(Gate::denies('category_create'), $this->respondPermissionDenied());

        Category::create([
            'name' => $request->name,
        ]);
        return $this->respondCreateMessageOnly('success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        abort_if(Gate::denies('category_access'), $this->respondPermissionDenied());

        return $this->respondCollection('success', $category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        abort_if(Gate::denies('category_update'), $this->respondPermissionDenied());

        CategoryApiService::manageCategory($request, $category);

        return $this->respondCreateMessageOnly('success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        abort_if(Gate::denies('category_delete'), $this->respondPermissionDenied());

        $category->delete();

        return $this->respondCreateMessageOnly('success');
    }

    public function query(Request $request)
    {
        abort_if(Gate::denies('category_access'), $this->respondPermissionDenied());

        $categories = DB::table('categories');
        
        $data = FilterQueryService::FilterQuery($request, $categories);

        return $this->respondCollectionWithPagination('success', $data);
    }
}
