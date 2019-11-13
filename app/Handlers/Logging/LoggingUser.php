<?php

namespace App\Handlers\Logging;

use App\Events\UserWasChange;
use App\Models\AdminActivity;

class LoggingUser
{
    public function handle(UserWasChange $event)
    {
        $admin = auth()->user();
        $data = $event->data;

        $action = isset($data['action']) ? $data['action'] : '';
        $content_id = $data['content_id'];
        $content_type = AdminActivity::CONTENT_TYPE_USER;
        $content_data = $data['data'];

        $description = isset($data['description']) ? $data['description'] : $admin->name . ' vừa thực hiện cập nhật thông tin user ' . $content_id;

        AdminActivity::addData($admin, $action, $content_id, $content_type, $description, $content_data);
    }
}
