<?php

namespace App\Http\Controllers\Cms;

use App\Common\Adapter\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Common\Utility;
use App\Models\Cms\AdminActivity as AdminActivityModel;

class AdminActivity extends Base
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $breadcrumb = [
            [
                'title' => 'Admin action log',
                'url' => '#',
                'active' => true
            ]
        ];
        //  request
        $keyword = $request->get('keyword');
        $action = $request->get('action');
        $type = $request->get('type');

        $from_date = empty($request->get('from_date')) ? Carbon::now()->startOfDay()->addDays(-15) : Carbon::parse($request->get('from_date'));
        $to_date = empty($request->get('to_date')) ? Carbon::now()->endOfDay() : Carbon::parse($request->get('to_date'));


        $query = AdminActivityModel::query()
            ->where('created_time', '>=', $from_date->toDateTimeString())
            ->where('created_time', '<=', $to_date->toDateTimeString());

        if (!empty($keyword)) {
            $query->where(DB::raw("admin_name"), 'like', "%{$keyword}%");
        }
        if (!empty($action)) {
            $query->where(DB::raw("action"), '=', $action);
        }
        if (!empty($type)) {
            $query->where(DB::raw("content_type"), '=', $type);
        }

        $datas = $query->orderBy('created_time', 'desc')
            ->paginate(Utility::LIMIT);

        $request->merge(['from_date' => $from_date->toDateTimeString()]);
        $request->merge(['to_date' => $to_date->toDateTimeString()]);


        return view('cms.admin_activity.index', compact('datas', 'breadcrumb'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $breadcrumb = [
            [
                'title' => 'Admin action log',
                'url' => route('cms.admin_activity.index'),
                'active' => false
            ],
            [
                'title' => 'Chi tiết log',
                'url' => '#',
                'active' => true
            ]
        ];
        $data = \App\Models\Cms\AdminActivity::query()->where('id', '=', $id)->get();

        return view('cms.admin_activity.show', compact('breadcrumb', 'data'));
    }


}