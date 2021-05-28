<?php

namespace App\Services;

class FilterQueryService
{

    public static function FilterQuery($request, $table)
    {
        // $data = null;
        //pagination params
        $pagination_param = $request["paginationParam"];
        //sorting params
        $sorting_params = $request["sortingParams"];

        //filter params
        $filter_params = $request["filter"]["filterParams"];
        $filter_logic = $request["filter"]["filterLogic"];
        $query = $table;
        if ($filter_logic == "AND") {
            foreach ($filter_params as $filter) {
                $query->where($filter['key'], $filter["filterExpression"], $filter["textValue"]["value"]);
            }
        }
        // dd($query->get());
        if ($filter_logic == "OR") {
            foreach ($filter_params as $filter) {
                $query->orWhere($filter['key'], $filter["filterExpression"], $filter["textValue"]["value"]);
            }
        }
        //Logic with OR AND

        if (isset($sorting_params)) {
            $query->orderBy(
                $sorting_params['key'],
                $sorting_params['sortType']
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
