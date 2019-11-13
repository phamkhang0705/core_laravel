<?php

namespace App\Http\Controllers\Cms;

use App\Common\Adapter\DB;
use Illuminate\Http\Request;  
use Carbon\Carbon; 
use App\Common\Utility;

class SystemLog extends Base
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
			    'title' => 'System log',
			    'url' => '#',
			    'active' => true
		    ]
		];
		//  request   
		$keyword = $request->get('keyword');
		$action = $request->get('action');
		$type = $request->get('type'); 
		$from_date = $request->get('from_date');
		$to_date = $request->get('to_date');
		
		$from = empty($from_date) ? Carbon::now()->addDays(-15) : Carbon::parse($from_date); 			
		$to = empty($to_date) ? Carbon::now() : Carbon::parse($to_date);  

		$request->merge(['from_date' => $from->toDateTimeString()]);
		$request->merge(['to_date' => $to->toDateTimeString()]);

        $datas = \App\Models\Cms\SystemLogs::query()
			->where('created_time', '>=', $from->toDateTimeString())
			->where('created_time', '<=', $to->toDateTimeString());

		if (!empty($keyword)) {
			$datas->where(DB::raw("user_name"), 'like', "%{$keyword}%");
			$datas->orWhere(DB::raw("action"), 'like', "%{$keyword}%");
		}			
            
        $datas = $datas ->orderBy('created_time', 'desc')
		                ->paginate(Utility::LIMIT);

        return view('cms.system_log.index', compact('datas', 'breadcrumb'));
    }
    
     
   
}