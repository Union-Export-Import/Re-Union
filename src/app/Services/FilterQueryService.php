<?php

namespace App\Services;

class FilterQueryService
{

    public static function FilterQuery($request, $users)
    {
        // $data = null;
        //pagination params
        $pagination_param = $request["paginationParam"];
        //sorting params
        $soring_params = $request["sortingParams"];

        //filter params
        $filter_params = $request["filter"]["filterParams"];
        $query = $users;

        foreach ($filter_params as $filter) {
            $query->where($filter['key'], $filter["filterExpression"], "%{$filter["textValue"]["value"]}%");
        }

        if (isset($soring_params)) {
            $query->orderBy(
                $soring_params['key'],
                $soring_params['sortType']
            );
        }

        if (isset($pagination_param)) {
            $data = $query->paginate(
                $pagination_param['pageSize'],
                ['*'],
                'page',
                $pagination_param['pageNumber']
            );
        }
        return $data;

    }
}
