<?php

namespace App\Handlers\ShowCase;

use App\Events\CategoryWasChange;
use App\Events\ShowCaseWasChange;
use App\Models\AdminActivity;
use Queue;
class Logging
{
    public function handle(ShowCaseWasChange $event)
    {
	    $data = $event->data;
	    $admin = auth()->user();
	    $action = isset($data['action'])?$data['action']:'';
	    $description = $admin->name.' vừa tác động show case '.
	    isset($data['content_name'])?$data['content_name']:$data['content_id'];
	    $content_id = $data['content_id'];
		AdminActivity::add($admin, $action, $content_id, 'category', $description);
    }
}