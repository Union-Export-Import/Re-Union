<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Services\CategoryApiService;
use App\Services\FilterQueryService;
use App\Traits\ResponserTrait;
use Illuminate\Support\Facades\DB;

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
        $category->delete();

        return $this->respondCreateMessageOnly('success');
    }

    public function query(Request $request)
    {
        $categories = DB::table('categories');
        // return $users->get();
        $data = FilterQueryService::FilterQuery($request, $categories);

        return $this->respondCollectionWithPagination('success', $data);
    }
}
