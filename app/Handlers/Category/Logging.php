<?php

namespace App\Handlers\Category;

use App\Events\CategoryWasChange;
use App\Models\AdminActivity;
use Queue;
class Logging
{
    public function handle(CategoryWasChange $event)
    {
	    $data = $event->data;
	    $admin = auth()->user();
	    $action = isset($data['action'])?$data['action']:'';
		$description = $admin->name.' vừa thực hiện cập nhật category '.
		(isset($data['content_name']) ?$data['content_name']:$data['content_id']);
	    $content_id = $data['content_id'];
		AdminActivity::add($admin, $action, $content_id, 'category', $description);
    }
}