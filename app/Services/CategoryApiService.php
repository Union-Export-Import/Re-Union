<?php

namespace App\Services;

use App\Models\Category;

class CategoryApiService
{
    public static function manageCategory($request, $category = null)
    {
        $category_id = $category && $category->id ? $category->id : null;

        Category::updateOrcreate(
            [
                'id' => $category_id,
            ],
            [
                'title' => $request->title,
            ]
        );
    }
}
