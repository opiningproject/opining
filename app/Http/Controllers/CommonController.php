<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommonController extends Controller
{
    static function getPaginateData(Request $request){
        $limit = $request->limit;
        $pageNo = $request->pageNo;
        $startLimit = 1;
        dd($request->all());
        $pageNo -= 1;
        $startLimit = $limit * $pageNo;

        $model = 'App\\Models\\' . $request->model;
        $paginateData = $model::offset($startLimit)->limit($limit);

        if ($request->order && $request->orderDir){
            $paginateData->order($request->order, $request->orderDir);
        }

        if ($request->has('conditions')) {
            foreach ($request->conditions as $key => $condition) {
                $paginateData->where($key, $condition);
            }
        }
        return ['status' => 200, 'data' => $paginateData->get()];
    }
}
