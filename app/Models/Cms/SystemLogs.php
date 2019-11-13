<?php

namespace App\Models\Cms;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class SystemLogs extends Model
{
    protected $guarded = [];
    protected $connection = 'mysql';
    protected $table = 'system_logs';
    const TABLE = 'system_logs';
    /* dung update_at va created_at ko*/
    const CREATED_AT = 'created_time';
    const UPDATED_AT = 'updated_time';

    public static function add($admin, $action = '', $data)
    {
        if (empty($admin)) {
            return false;
        }
        try {
            ;
            $insert_data = [
                'user_id' => $admin->id,
                'user_name' => $admin->name,
                'action' => $action,
                'data' => json_encode($data)
            ];
            $odm = new self($insert_data);
            $odm->save($insert_data);

            return true;
        } catch (\Exception $e) {
            throw $e;
        }

    }

    public function getCreatedTime()
    {
        return date('H:i d/m/Y', strtotime($this->created_time));
    }

}
