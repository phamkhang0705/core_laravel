<?php

namespace App\Http\Controllers\Cms;

use Illuminate\Http\Request;

class Dashboard extends Base
{
    /**
     * Dashboard constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

	    //$big_menus = \App\Common\Permission::lists();
	    //print_r($big_menus);exit;

		/*
		 * WHERE
	deal_comment.id = 395
AND deal_comment.deal_id = 185394
AND deal_comment.user_id = 2014570 SELECT
		 * */
	    //$id = 395;
	    //$deal_id = 185394;
	    //$user_id = 2014570;
		//$datas = DealComments::getImages($id, $user_id);
	    //print_r($datas);exit;

	    /*$tags = ['tra sua', 'trung', 'tung'];

	    $tags_not_exist = Tag::query()->whereIn('name', $tags)->get();
	    $tags_not_exist = array_pluck($tags_not_exist,'name');
	    $a  = array_diff($tags,$tags_not_exist);

	    /*$section = HomeSectionConfiguration::query()
		    ->where('id',21)->first();


	    $datas = $section->userGroup()->toSql();
	    print_r($datas);exit;
	    print_r($section);exit;
	    $data = $section->manualItemSection();



	    $data = $data->get();
	    print_r($data);exit;*/
		
	    /*$datas = Menu::getListMenuForDisPlay();
	    print_r($datas);exit;*/
        return view('cms.dashboard.index');
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
