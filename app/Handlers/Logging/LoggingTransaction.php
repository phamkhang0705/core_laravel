<?php

namespace App\Handlers\Logging;

use App\Events\CashoutWasChange;
use App\Models\AdminActivity;

class LoggingTransaction
{
    public function handle(CashoutWasChange $event)
    {
        $admin = auth()->user();
        $data = $event->data;

        $action = isset($data['action']) ? $data['action'] : '';
        $content_id = $data['content_id'];
        $content_type = $data['content_type'];
        $content_data = $data['data'];
        $description = isset($data['description']) ? $data['description'] : $admin->name . ' thực hiện '.$action.' cho GD:' . $content_id;
        AdminActivity::addData($admin, $action, $content_id, $content_type, $description, $content_data);
    }
}
